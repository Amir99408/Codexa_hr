<?php

namespace App\Livewire\Portal;

use App\Models\ShiftAssignment;
use App\Models\ShiftSwapRequest;
use App\Models\Employee;
use Livewire\Component;
use Carbon\Carbon;

class EmployeeShifts extends Component
{
    public int $selectedMonth;
    public int $selectedYear;

    // Swap request
    public bool   $showSwapModal     = false;
    public ?int   $myAssignmentId    = null;
    public ?int   $swap_employee_id  = null;
    public ?int   $swap_assignment_id = null;
    public string $swap_reason       = '';
    public string $message           = '';

    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear  = now()->year;
    }

    public function openSwap(int $assignmentId): void
    {
        $this->myAssignmentId   = $assignmentId;
        $this->swap_employee_id = null;
        $this->swap_assignment_id = null;
        $this->swap_reason      = '';
        $this->showSwapModal    = true;
    }

    public function submitSwap(): void
    {
        $this->validate([
            'swap_assignment_id' => 'required|exists:shift_assignments,id',
            'swap_reason'        => 'nullable|string',
        ]);

        $employee  = auth()->user()->employee;
        $myAssignment = ShiftAssignment::findOrFail($this->myAssignmentId);
        $theirAssignment = ShiftAssignment::findOrFail($this->swap_assignment_id);

        ShiftSwapRequest::create([
            'requester_id'            => $employee->id,
            'requested_id'            => $theirAssignment->employee_id,
            'requester_assignment_id' => $this->myAssignmentId,
            'requested_assignment_id' => $this->swap_assignment_id,
            'reason'                  => $this->swap_reason,
        ]);

        $this->showSwapModal = false;
        $this->message       = 'Swap request submitted!';
    }

    public function render()
    {
        $employee = auth()->user()->employee;

        $myShifts = ShiftAssignment::where('employee_id', $employee?->id)
            ->whereMonth('date', $this->selectedMonth)
            ->whereYear('date', $this->selectedYear)
            ->with('shift')
            ->orderBy('date')
            ->get();

        $swapRequests = ShiftSwapRequest::where('requester_id', $employee?->id)
            ->orWhere('requested_id', $employee?->id)
            ->with(['requester', 'requested', 'requesterAssignment.shift', 'requestedAssignment.shift'])
            ->latest()
            ->take(10)
            ->get();

        // Other employees shifts for swap
        $otherShifts = ShiftAssignment::whereMonth('date', $this->selectedMonth)
            ->whereYear('date', $this->selectedYear)
            ->where('employee_id', '!=', $employee?->id)
            ->with(['employee', 'shift'])
            ->get();

        $employees = Employee::where('status', 'active')
            ->where('id', '!=', $employee?->id)
            ->get();

        return view('livewire.portal.employee-shifts', [
            'myShifts'     => $myShifts,
            'swapRequests' => $swapRequests,
            'otherShifts'  => $otherShifts,
            'employees'    => $employees,
        ])->layout('layouts.portal', ['title' => 'My Shifts']);
    }
}