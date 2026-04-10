<?php

namespace App\Livewire\Reports;

use App\Models\Payroll;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class PayrollReport extends Component
{
    use WithPagination;

    public int    $selectedMonth;
    public int    $selectedYear;
    public string $filterDept   = '';
    public string $filterStatus = '';
    public string $search       = '';

    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear  = now()->year;
    }

    public function render()
    {
        $query = Payroll::query()
            ->with(['employee.department'])
            ->where('month', $this->selectedMonth)
            ->where('year',  $this->selectedYear)
            ->when($this->filterStatus, fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->when($this->filterDept, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('department_id', $this->filterDept)
                )
            )
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', '%'.$this->search.'%')
                       ->orWhere('last_name',  'like', '%'.$this->search.'%')
                )
            )
            ->latest();

        $records     = $query->paginate(20);
        $departments = Department::all();

        $allRecords  = $query->get();
        $summary = [
            'total_employees'  => $allRecords->count(),
            'total_basic'      => $allRecords->sum('basic_salary'),
            'total_earnings'   => $allRecords->sum('total_earnings'),
            'total_deductions' => $allRecords->sum('total_deductions'),
            'total_net'        => $allRecords->sum('net_salary'),
            'total_paid'       => $allRecords->where('status', 'paid')->count(),
        ];

        // Department wise breakdown
        $deptBreakdown = Payroll::query()
            ->with('employee.department')
            ->where('month', $this->selectedMonth)
            ->where('year',  $this->selectedYear)
            ->get()
            ->groupBy(fn($p) => $p->employee->department?->name ?? 'No Department')
            ->map(fn($group) => [
                'count'     => $group->count(),
                'net_total' => $group->sum('net_salary'),
            ]);

        return view('livewire.reports.payroll-report', [
            'records'        => $records,
            'departments'    => $departments,
            'summary'        => $summary,
            'deptBreakdown'  => $deptBreakdown,
        ])->layout('layouts.app', ['title' => 'Payroll Report']);
    }
}