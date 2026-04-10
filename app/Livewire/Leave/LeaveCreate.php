<?php

namespace App\Livewire\Leave;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Employee;
use Livewire\Component;
use Carbon\Carbon;

class LeaveCreate extends Component
{
    public ?int   $employee_id   = null;
    public ?int   $leave_type_id = null;
    public string $from_date     = '';
    public string $to_date       = '';
    public string $reason        = '';
    public float  $days          = 0;

    public function updatedFromDate(): void
    {
        $this->calculateDays();
    }

    public function updatedToDate(): void
    {
        $this->calculateDays();
    }

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

    protected function rules(): array
    {
        return [
            'employee_id'   => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'reason'        => 'nullable|string|max:500',
        ];
    }

    public function save(): void
    {
        $this->validate();

        Leave::create([
            'employee_id'   => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'from_date'     => $this->from_date,
            'to_date'       => $this->to_date,
            'days'          => $this->days,
            'reason'        => $this->reason,
            'status'        => 'pending',
        ]);

        session()->flash('success', 'Leave request submitted successfully.');
        $this->redirect(route('leave.index'));
    }

    public function render()
    {
        return view('livewire.leave.leave-create', [
            'employees'   => Employee::where('status', 'active')->get(),
            'leaveTypes'  => LeaveType::all(),
        ])->layout('layouts.app', ['title' => 'Apply Leave']);
    }
}
