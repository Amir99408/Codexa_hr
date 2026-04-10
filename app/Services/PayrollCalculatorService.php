<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Attendance;
use App\Models\SalaryComponent;
use Carbon\Carbon;

class PayrollCalculatorService
{
    public function calculate(Employee $employee, int $month, int $year): Payroll
    {
        // Get attendance summary
        $daysInMonth  = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $presentDays  = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereIn('status', ['present', 'late', 'half_day', 'work_from_home'])
            ->count();
        $absentDays   = $daysInMonth - $presentDays;
        $basicSalary  = $employee->basic_salary;

        // Get all active salary components
        $components   = SalaryComponent::where('is_active', true)->get();

        $earnings     = [];
        $deductions   = [];
        $totalEarnings    = 0;
        $totalDeductions  = 0;

        foreach ($components as $component) {
            // Check if employee has custom value
            $empSalary    = $employee->employeeSalaries()
                ->where('salary_component_id', $component->id)
                ->first();

            $value = $empSalary?->custom_value ?? $component->value;

            // Calculate amount
            $amount = $component->calculation_type === 'percentage'
                ? ($basicSalary * $value / 100)
                : $value;

            if ($component->type === 'earning') {
                $earnings[]      = ['name' => $component->name, 'amount' => $amount];
                $totalEarnings  += $amount;
            } else {
                $deductions[]    = ['name' => $component->name, 'amount' => $amount];
                $totalDeductions += $amount;
            }
        }

        $grossSalary = $basicSalary + $totalEarnings;
        $netSalary   = $grossSalary - $totalDeductions;

        // Create or update payroll record
        $payroll = Payroll::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'month'       => $month,
                'year'        => $year,
            ],
            [
                'basic_salary'     => $basicSalary,
                'total_earnings'   => $totalEarnings,
                'total_deductions' => $totalDeductions,
                'gross_salary'     => $grossSalary,
                'net_salary'       => $netSalary,
                'working_days'     => $daysInMonth,
                'present_days'     => $presentDays,
                'absent_days'      => $absentDays,
                'status'           => 'draft',
            ]
        );

        // Delete old items and recreate
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

        return $payroll;
    }
}