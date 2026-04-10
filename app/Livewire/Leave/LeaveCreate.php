<?php

namespace App\Livewire\Leave;

use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Employee;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
                $this->days = $this->countWorkingDays($from, $to);
            }
        }
    }

    private function countWorkingDays(Carbon $from, Carbon $to): int
    {
        $holidays = Holiday::whereBetween('date', [
                $from->toDateString(),
                $to->toDateString(),
            ])
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        $days = 0;
        foreach (CarbonPeriod::create($from, $to) as $date) {
            if (!$date->isWeekend() && !in_array($date->format('Y-m-d'), $holidays)) {
                $days++;
            }
        }
        return $days;
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

        // Enforce leave balance
        $leaveType = LeaveType::find($this->leave_type_id);
        if ($leaveType && $leaveType->days_allowed > 0) {
            $usedDays = Leave::where('employee_id', $this->employee_id)
                ->where('leave_type_id', $this->leave_type_id)
                ->whereIn('status', ['approved', 'pending'])
                ->whereYear('from_date', Carbon::parse($this->from_date)->year)
                ->sum('days');

            $available = $leaveType->days_allowed - $usedDays;
            if ($this->days > $available) {
                $this->addError('days', "Exceeds allowed balance for {$leaveType->name}. Available: {$available} working day(s).");
                return;
            }
        }

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
