<?php

namespace App\Livewire\Payroll;

use App\Models\Advance;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Department;
use App\Services\PayrollCalculatorService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\AuditService;
use App\Services\NotificationService;

class PayrollIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterDept   = '';
    public string $filterStatus = '';
    public string $message      = '';
    public int    $selectedMonth;
    public int    $selectedYear;

    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear  = now()->year;
    }

    // Run payroll for all employees
    public function runPayroll(): void
    {
        $employees = Employee::where('status', 'active')->get();
        $service   = new PayrollCalculatorService();

        DB::transaction(function () use ($employees, $service) {
            foreach ($employees as $employee) {
                $payroll = $service->calculate($employee, $this->selectedMonth, $this->selectedYear);

                AuditService::log(
                    action: 'created',
                    model: 'Payroll',
                    description: "Ran payroll for {$employee->full_name} — Net: {$payroll->net_salary}",
                    modelId: $payroll->id,
                );

                // Update advance balance using the Payroll model's saved fields
                if ($payroll->advance_id && $payroll->advance_deduction > 0) {
                    $advance = Advance::find($payroll->advance_id);
                    if ($advance && $advance->status === 'active') {
                        $advance->paid_amount      = round((float) $advance->paid_amount + (float) $payroll->advance_deduction, 2);
                        $advance->remaining_amount = round((float) $advance->remaining_amount - (float) $payroll->advance_deduction, 2);

                        if ($advance->remaining_amount <= 0) {
                            $advance->remaining_amount = 0;
                            $advance->status           = 'completed';
                        }
                        $advance->save();
                    }
                }
            }
        });

        $this->message = 'Payroll processed for ' . $employees->count() . ' employees.';
    }

    // Mark as paid
    public function markPaid(int $id): void
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->update(['status' => 'paid']);

        $payrolls = Payroll::where('month', $this->selectedMonth)
            ->where('year', $this->selectedYear)
            ->with('employee')
            ->get();

        foreach ($payrolls as $p) {
            NotificationService::notifyEmployee(
                employeeId: $p->employee_id,
                title: 'Salary Credited',
                message: "Your salary of " . number_format($p->net_salary) . " for {$p->month_name} has been paid.",
                type: 'success',
                url: '/portal/payslips',
            );
        }

        AuditService::log(
            action: 'paid',
            model: 'Payroll',
            description: "Marked payroll as paid for month {$payroll->month_name}",
            modelId: $payroll->id,
        );
        $this->message = 'Payroll marked as paid.';
    }

    // Mark as processed
    public function markProcessed(int $id): void
    {
        Payroll::findOrFail($id)->update(['status' => 'processed']);
        $this->message = 'Payroll marked as processed.';
    }

    // Delete payroll
    public function delete(int $id): void
    {
        Payroll::findOrFail($id)->delete();
        $this->message = 'Payroll record deleted.';
    }

    public function render()
    {
        // Filter by payroll month/year columns, not created_at
        $payrolls = Payroll::query()
            ->with(['employee.department'])
            ->where('month', $this->selectedMonth)
            ->where('year',  $this->selectedYear)
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', '%'.$this->search.'%')
                       ->orWhere('last_name',  'like', '%'.$this->search.'%')
                )
            )
            ->when($this->filterStatus, fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->when($this->filterDept, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('department_id', $this->filterDept)
                )
            )
            ->latest()
            ->paginate(15);

        $departments  = Department::all();
        $totalNet     = Payroll::where('month', $this->selectedMonth)
                            ->where('year', $this->selectedYear)
                            ->sum('net_salary');
        $totalPaid    = Payroll::where('month', $this->selectedMonth)
                            ->where('year', $this->selectedYear)
                            ->where('status', 'paid')->count();
        $totalDraft   = Payroll::where('month', $this->selectedMonth)
                            ->where('year', $this->selectedYear)
                            ->where('status', 'draft')->count();

        return view('livewire.payroll.payroll-index', [
            'payrolls'    => $payrolls,
            'departments' => $departments,
            'totalNet'    => $totalNet,
            'totalPaid'   => $totalPaid,
            'totalDraft'  => $totalDraft,
        ])->layout('layouts.app', ['title' => 'Payroll']);
    }
}
