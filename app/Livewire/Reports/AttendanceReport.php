<?php

namespace App\Livewire\Reports;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class AttendanceReport extends Component
{
    use WithPagination;

    public string $from_date   = '';
    public string $to_date     = '';
    public string $filterDept  = '';
    public string $filterStatus = '';
    public string $search      = '';

    public function mount(): void
    {
        $this->from_date = now()->startOfMonth()->format('Y-m-d');
        $this->to_date   = now()->format('Y-m-d');
    }

    public function updatingFromDate(): void { $this->resetPage(); }
    public function updatingToDate(): void   { $this->resetPage(); }
    public function updatingFilterDept(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function render()
    {
        $query = Attendance::query()
            ->with(['employee.department'])
            ->when($this->from_date, fn($q) =>
                $q->whereDate('date', '>=', $this->from_date)
            )
            ->when($this->to_date, fn($q) =>
                $q->whereDate('date', '<=', $this->to_date)
            )
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
            ->orderBy('date', 'desc');

        $records     = $query->paginate(20);
        $departments = Department::all();

        // Summary stats
        $allRecords  = $query->get();
        $summary = [
            'total'    => $allRecords->count(),
            'present'  => $allRecords->where('status', 'present')->count(),
            'absent'   => $allRecords->where('status', 'absent')->count(),
            'late'     => $allRecords->where('status', 'late')->count(),
            'half_day' => $allRecords->where('status', 'half_day')->count(),
            'wfh'      => $allRecords->where('status', 'work_from_home')->count(),
        ];

        return view('livewire.reports.attendance-report', [
            'records'     => $records,
            'departments' => $departments,
            'summary'     => $summary,
        ])->layout('layouts.app', ['title' => 'Attendance Report']);
    }
}