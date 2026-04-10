<?php

namespace App\Livewire\Shifts;

use App\Models\Shift;
use App\Models\ShiftSwapRequest;
use App\Services\NotificationService;
use Livewire\Component;

class ShiftIndex extends Component
{
    // Shift CRUD
    public bool   $showModal   = false;
    public ?int   $editId      = null;
    public string $name        = '';
    public string $start_time  = '09:00';
    public string $end_time    = '17:00';
    public string $color       = '#0f4c81';
    public string $description = '';
    public string $message     = '';

    public function openModal(?int $id = null): void
    {
        $this->resetForm();
        if ($id) {
            $shift             = Shift::findOrFail($id);
            $this->editId      = $id;
            $this->name        = $shift->name;
            $this->start_time  = $shift->start_time;
            $this->end_time    = $shift->end_time;
            $this->color       = $shift->color;
            $this->description = $shift->description ?? '';
        }
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'       => 'required|string|max:100',
            'start_time' => 'required',
            'end_time'   => 'required',
            'color'      => 'required|string',
        ]);

        $data = [
            'name'        => $this->name,
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'color'       => $this->color,
            'description' => $this->description,
        ];

        if ($this->editId) {
            Shift::findOrFail($this->editId)->update($data);
            $this->message = 'Shift updated.';
        } else {
            Shift::create($data);
            $this->message = 'Shift created.';
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Shift::destroy($id);
        $this->message = 'Shift deleted.';
    }

    public function approveSwap(int $id): void
    {
        $swap = ShiftSwapRequest::with(['requester', 'requested'])->findOrFail($id);

        // Swap the shift assignments
        $requesterShiftId = $swap->requesterAssignment->shift_id;
        $requestedShiftId = $swap->requestedAssignment->shift_id;

        $swap->requesterAssignment->update(['shift_id' => $requestedShiftId]);
        $swap->requestedAssignment->update(['shift_id' => $requesterShiftId]);

        $swap->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
        ]);

        NotificationService::notifyEmployee(
            employeeId: $swap->requester_id,
            title: 'Shift Swap Approved ✅',
            message: "Your shift swap request with {$swap->requested->full_name} has been approved.",
            type: 'success',
        );

        $this->message = 'Shift swap approved.';
    }

    public function rejectSwap(int $id): void
    {
        $swap = ShiftSwapRequest::findOrFail($id);
        $swap->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        NotificationService::notifyEmployee(
            employeeId: $swap->requester_id,
            title: 'Shift Swap Rejected ❌',
            message: "Your shift swap request has been rejected.",
            type: 'danger',
        );

        $this->message = 'Shift swap rejected.';
    }

    private function resetForm(): void
    {
        $this->editId      = null;
        $this->name        = '';
        $this->start_time  = '09:00';
        $this->end_time    = '17:00';
        $this->color       = '#0f4c81';
        $this->description = '';
    }

    public function render()
    {
        $shifts    = Shift::withCount('assignments')->get();
        $swapRequests = ShiftSwapRequest::with([
            'requester', 'requested',
            'requesterAssignment.shift',
            'requestedAssignment.shift',
        ])->where('status', 'pending')->latest()->get();

        return view('livewire.shifts.shift-index', [
            'shifts'       => $shifts,
            'swapRequests' => $swapRequests,
        ])->layout('layouts.app', ['title' => 'Shift Management']);
    }
}