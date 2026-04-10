<?php

namespace App\Livewire\Reports;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveReport extends Component
{
    use WithPagination;

    public string $from_date     = '';
    public string $to_date       = '';
    public string $filterDept    = '';
    public string $filterStatus  = '';
    public string $filterType    = '';
    public string $search        = '';

    public function mount(): void
    {
        $this->from_date = now()->startOfMonth()->format('Y-m-d');
        $this->to_date   = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $query = Leave::query()
            ->with(['employee.department', 'leaveType'])
            ->when($this->from_date, fn($q) =>
                $q->whereDate('from_date', '>=', $this->from_date)
            )
            ->when($this->to_date, fn($q) =>
                $q->whereDate('from_date', '<=', $this->to_date)
            )
            ->when($this->filterStatus, fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->when($this->filterType, fn($q) =>
                $q->where('leave_type_id', $this->filterType)
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
        $leaveTypes  = LeaveType::all();

        $allRecords  = $query->get();
        $summary = [
            'total'    => $allRecords->count(),
            'approved' => $allRecords->where('status', 'approved')->count(),
            'pending'  => $allRecords->where('status', 'pending')->count(),
            'rejected' => $allRecords->where('status', 'rejected')->count(),
            'days'     => $allRecords->where('status', 'approved')->sum('days'),
        ];

        return view('livewire.reports.leave-report', [
            'records'     => $records,
            'departments' => $departments,
            'leaveTypes'  => $leaveTypes,
            'summary'     => $summary,
        ])->layout('layouts.app', ['title' => 'Leave Report']);
    }
}