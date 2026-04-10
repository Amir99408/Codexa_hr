<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\AuditService;
use App\Services\NotificationService;

class LeaveIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';
    public string $filterDept   = '';
    public string $message      = '';
    public ?int $rejectId       = null;
    public string $rejectionReason = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Approve leave
    public function approve(int $id): void
    {
        $leave = Leave::findOrFail($id);
        $leave->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
        ]);

// Notify employee
NotificationService::notifyEmployee(
    employeeId: $leave->employee_id,
    title: 'Leave Approved ✅',
    message: "Your {$leave->leaveType->name} request for {$leave->days} day(s) has been approved.",
    type: 'success',
    url: '/portal/leave/apply',
);

// Notify admins
NotificationService::notifyAdmins(
    title: 'Leave Approved',
    message: "{$leave->employee->full_name}'s leave has been approved.",
    type: 'success',
);

        AuditService::log(
    action: 'approved',
    model: 'Leave',
    description: "Approved leave for {$leave->employee->full_name} ({$leave->days} days)",
    modelId: $leave->id,
);
        $this->message = 'Leave approved successfully.';
    }

    // Open reject modal
    public function confirmReject(int $id): void
    {
        $this->rejectId         = $id;
        $this->rejectionReason  = '';
    }

    // Reject leave
    public function reject(): void
    {
        $this->validate([
            'rejectionReason' => 'required|string|min:5',
        ]);

        $leave = Leave::findOrFail($this->rejectId);
        $leave->update([
            'status'           => 'rejected',
            'approved_by'      => auth()->id(),
            'rejection_reason' => $this->rejectionReason,
        ]);

NotificationService::notifyEmployee(
    employeeId: $leave->employee_id,
    title: 'Leave Rejected ❌',
    message: "Your {$leave->leaveType->name} request has been rejected.",
    type: 'danger',
    url: '/portal/leave/apply',
);

        AuditService::log(
            action: 'rejected',
            model: 'Leave',
            description: "Rejected leave for {$leave->employee->full_name}",
            modelId: $leave->id,
        );

        $this->rejectId        = null;
        $this->rejectionReason = '';
        $this->message         = 'Leave rejected.';
    }

    // Delete leave
    public function delete(int $id): void
    {
        Leave::findOrFail($id)->delete();
        $this->message = 'Leave request deleted.';
    }

    public function render()
    {
        $leaves = Leave::query()
            ->with(['employee.department', 'leaveType'])
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
        $pending      = Leave::where('status', 'pending')->count();
        $approved     = Leave::where('status', 'approved')->count();
        $rejected     = Leave::where('status', 'rejected')->count();

        return view('livewire.leave.leave-index', [
            'leaves'      => $leaves,
            'departments' => $departments,
            'pending'     => $pending,
            'approved'    => $approved,
            'rejected'    => $rejected,
        ])->layout('layouts.app', ['title' => 'Leave Management']);
    }
}
