<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Attendance;
use App\Models\SalaryComponent;
use App\Models\Advance;
use App\Models\Holiday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cache;

class PayrollCalculatorService
{
    public function calculate(Employee $employee, int $month, int $year): Payroll
    {
        // Never overwrite a paid payroll
        $existing = Payroll::where('employee_id', $employee->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($existing && $existing->status === 'paid') {
            return $existing;
        }

        $firstOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $lastOfMonth  = $firstOfMonth->copy()->endOfMonth();

        // --- Working days: exclude weekends and public holidays ---
        $holidayDates = Cache::remember("holidays_{$year}_{$month}", 3600, fn() =>
            Holiday::whereBetween('date', [
                    $firstOfMonth->toDateString(),
                    $lastOfMonth->toDateString(),
                ])
                ->pluck('date')
                ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
                ->toArray()
        );

        $workingDays = 0;
        foreach (CarbonPeriod::create($firstOfMonth, $lastOfMonth) as $date) {
            if (!$date->isWeekend() && !in_array($date->format('Y-m-d'), $holidayDates)) {
                $workingDays++;
            }
        }

        // --- Present days: half_day counts as 0.5 ---
        $fullDays = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereIn('status', ['present', 'late', 'work_from_home'])
            ->count();

        $halfDays = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'half_day')
            ->count();

        $presentDays = $fullDays + ($halfDays * 0.5);
        $absentDays  = max(0, $workingDays - $presentDays);

        // --- Overtime hours for the month ---
        $totalOvertimeHours = (float) Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date',  $year)
            ->sum('overtime_hours');

        $basicSalary = (float) $employee->basic_salary;

        // --- Prorate basic salary based on actual attendance ---
        // Per-day rate based on working days, multiplied by days actually present
        $adjustedBasicSalary = $workingDays > 0
            ? round($basicSalary * ($presentDays / $workingDays), 2)
            : 0.0;

        // --- Advance deduction ---
        $advance = Advance::where('employee_id', $employee->id)
            ->where('status', 'active')
            ->first();

        $advanceDeduction = $advance ? (float) $advance->monthly_deduction : 0.0;

        // --- Salary components (earnings & deductions) ---
        $components = Cache::remember('salary_components_active', 600, fn() =>
            SalaryComponent::where('is_active', true)->get()
        );
        $earnings        = [];
        $deductions      = [];
        $totalEarnings   = 0.0;
        $totalDeductions = 0.0;

        foreach ($components as $component) {
            $empSalary = $employee->employeeSalaries()
                ->where('salary_component_id', $component->id)
                ->first();

            $value = (float) ($empSalary?->custom_value ?? $component->value);

            // Round percentage calculations to 2 decimal places to avoid floating-point drift
            $amount = $component->calculation_type === 'percentage'
                ? round($basicSalary * $value / 100, 2)
                : round($value, 2);

            if ($component->type === 'earning') {
                $earnings[]     = ['name' => $component->name, 'amount' => $amount];
                $totalEarnings += $amount;
            } else {
                $deductions[]     = ['name' => $component->name, 'amount' => $amount];
                $totalDeductions += $amount;
            }
        }

        // --- Overtime pay: hourly rate × 1.5 × OT hours ---
        $otPay = 0.0;
        if ($totalOvertimeHours > 0 && $workingDays > 0) {
            $dailyRate  = $basicSalary / $workingDays;
            $hourlyRate = $dailyRate / 8;
            $otPay      = round($hourlyRate * 1.5 * $totalOvertimeHours, 2);

            $earnings[]     = ['name' => 'Overtime Pay', 'amount' => $otPay];
            $totalEarnings += $otPay;
        }

        $totalEarnings   = round($totalEarnings,   2);
        $totalDeductions = round($totalDeductions, 2);

        // Gross = prorated basic + full earnings (allowances are entitlements, not prorated)
        $grossSalary = round($adjustedBasicSalary + $totalEarnings, 2);

        // Cap advance deduction so net salary never goes negative
        $maxAdvance       = max(0.0, $grossSalary - $totalDeductions);
        $advanceDeduction = min($advanceDeduction, $maxAdvance);

        $netSalary = round(max(0.0, $grossSalary - $totalDeductions - $advanceDeduction), 2);

        // --- Persist payroll record ---
        $payroll = Payroll::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'month'       => $month,
                'year'        => $year,
            ],
            [
                'basic_salary'      => $basicSalary,
                'total_earnings'    => $totalEarnings,
                'total_deductions'  => $totalDeductions,
                'gross_salary'      => $grossSalary,
                'net_salary'        => $netSalary,
                'working_days'      => $workingDays,
                'present_days'      => $presentDays,
                'absent_days'       => $absentDays,
                'advance_deduction' => $advanceDeduction,
                'advance_id'        => $advance?->id,
            ]
        );

        // New record: set to draft. Existing record: keep its current status
        if ($payroll->wasRecentlyCreated) {
            $payroll->update(['status' => 'draft']);
        }

        // --- Rebuild line items ---
        $payroll->items()->delete();

        foreach ($earnings as $item) {
            PayrollItem::create([
                'payroll_id' => $payroll->id,
                'name'       => $item['name'],
                'type'       => 'earning',
                'amount'     => $item['amount'],
            ]);
        }

        foreach ($deductions as $item) {
            PayrollItem::create([
                'payroll_id' => $payroll->id,
                'name'       => $item['name'],
                'type'       => 'deduction',
                'amount'     => $item['amount'],
            ]);
        }

        if ($advanceDeduction > 0) {
            PayrollItem::create([
                'payroll_id' => $payroll->id,
                'name'       => 'Advance Deduction',
                'type'       => 'deduction',
                'amount'     => $advanceDeduction,
            ]);
        }

        return $payroll;
    }
}
