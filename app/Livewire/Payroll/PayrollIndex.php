<?php

namespace App\Livewire\Payroll;

use App\Models\Advance;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Department;
use App\Services\PayrollCalculatorService;
use App\Jobs\ProcessPayrollJob;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\AuditService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Mail;
use App\Mail\PayslipPaidMail;

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

    // Run payroll for all employees (dispatched as background jobs)
    public function runPayroll(): void
    {
        $employees = Employee::where('status', 'active')->get();

        foreach ($employees as $employee) {
            ProcessPayrollJob::dispatch($employee->id, $this->selectedMonth, $this->selectedYear);
        }

        $this->message = "Payroll queued for {$employees->count()} employee(s). Results will appear shortly.";
    }

    // Mark as paid
    public function markPaid(int $id): void
    {
        $payroll = Payroll::with(['employee.user', 'items'])->findOrFail($id);
        $payroll->update(['status' => 'paid']);

        NotificationService::notifyEmployee(
            employeeId: $payroll->employee_id,
            title: 'Salary Credited',
            message: "Your salary of " . number_format($payroll->net_salary) . " for {$payroll->month_name} has been paid.",
            type: 'success',
            url: '/portal/payslips',
        );

        if ($payroll->employee?->user?->email) {
            Mail::to($payroll->employee->user->email)->queue(new PayslipPaidMail($payroll));
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

    public function export(): void
    {
        $this->redirect(route('export.payroll', [
            'month'  => $this->selectedMonth,
            'year'   => $this->selectedYear,
            'dept'   => $this->filterDept,
            'status' => $this->filterStatus,
        ]));
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

        $departments  = \Illuminate\Support\Facades\Cache::remember('departments_all', 600, fn() => Department::all());
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
