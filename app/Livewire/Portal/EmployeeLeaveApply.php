<?php

namespace App\Livewire\Portal;

use App\Models\Leave;
use App\Models\LeaveType;
use Livewire\Component;
use Carbon\Carbon;
use App\Services\NotificationService;

class EmployeeLeaveApply extends Component
{
    public ?int   $leave_type_id = null;
    public string $from_date     = '';
    public string $to_date       = '';
    public string $reason        = '';
    public float  $days          = 0;
    public string $message       = '';
    public string $tab           = 'apply'; // apply | history

    public function updatedFromDate(): void { $this->calculateDays(); }
    public function updatedToDate(): void   { $this->calculateDays(); }

    private function calculateDays(): void
    {
        if ($this->from_date && $this->to_date) {
            $from = Carbon::parse($this->from_date);
            $to   = Carbon::parse($this->to_date);
            if ($to->greaterThanOrEqualTo($from)) {
                $this->days = $from->diffInDays($to) + 1;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date'     => 'required|date|after_or_equal:today',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'reason'        => 'nullable|string|max:500',
        ]);

        $employee = auth()->user()->employee;

        Leave::create([
            'employee_id'   => $employee->id,
            'leave_type_id' => $this->leave_type_id,
            'from_date'     => $this->from_date,
            'to_date'       => $this->to_date,
            'days'          => $this->days,
            'reason'        => $this->reason,
            'status'        => 'pending',
        ]);

        // Notify admins of new leave request
NotificationService::notifyAdmins(
    title: 'New Leave Request 📋',
    message: "{$employee->full_name} applied for {$this->days} day(s) leave.",
    type: 'info',
    url: '/leave',
);

        $this->leave_type_id = null;
        $this->from_date     = '';
        $this->to_date       = '';
        $this->reason        = '';
        $this->days          = 0;
        $this->message       = 'Leave request submitted successfully!';
        $this->tab           = 'history';
    }

    public function render()
    {
        $employee   = auth()->user()->employee;
        $leaveTypes = LeaveType::all();
        $myLeaves   = Leave::where('employee_id', $employee?->id)
            ->with('leaveType')
            ->latest()
            ->get();

        return view('livewire.portal.employee-leave-apply', [
            'leaveTypes' => $leaveTypes,
            'myLeaves'   => $myLeaves,
        ])->layout('layouts.portal', ['title' => 'My Leaves']);
    }
}
