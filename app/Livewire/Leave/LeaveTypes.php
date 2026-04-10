<?php

namespace App\Livewire\Leave;

use App\Models\LeaveType;
use Livewire\Component;

class LeaveTypes extends Component
{
    public string $name         = '';
    public int    $days_allowed = 0;
    public bool   $carry_forward = false;
    public bool   $is_paid      = true;
    public string $color        = '#0f4c81';
    public ?int   $editId       = null;
    public ?int   $deleteId     = null;
    public bool   $showForm     = false;
    public string $message      = '';

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $type               = LeaveType::findOrFail($id);
        $this->editId       = $id;
        $this->name         = $type->name;
        $this->days_allowed = $type->days_allowed;
        $this->carry_forward = $type->carry_forward;
        $this->is_paid      = $type->is_paid;
        $this->color        = $type->color;
        $this->showForm     = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'         => 'required|string|max:100',
            'days_allowed' => 'required|integer|min:0',
            'color'        => 'required|string',
        ]);

        if ($this->editId) {
            LeaveType::findOrFail($this->editId)->update([
                'name'          => $this->name,
                'days_allowed'  => $this->days_allowed,
                'carry_forward' => $this->carry_forward,
                'is_paid'       => $this->is_paid,
                'color'         => $this->color,
            ]);
            $this->message = 'Leave type updated.';
        } else {
            LeaveType::create([
                'name'          => $this->name,
                'days_allowed'  => $this->days_allowed,
                'carry_forward' => $this->carry_forward,
                'is_paid'       => $this->is_paid,
                'color'         => $this->color,
            ]);
            $this->message = 'Leave type created.';
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    public function delete(): void
    {
        LeaveType::findOrFail($this->deleteId)->delete();
        $this->deleteId = null;
        $this->message  = 'Leave type deleted.';
    }

    private function resetForm(): void
    {
        $this->name          = '';
        $this->days_allowed  = 0;
        $this->carry_forward = false;
        $this->is_paid       = true;
        $this->color         = '#0f4c81';
        $this->editId        = null;
    }

    public function render()
    {
        return view('livewire.leave.leave-types', [
            'leaveTypes' => LeaveType::withCount('leaves')->get(),
        ])->layout('layouts.app', ['title' => 'Leave Types']);
    }
}
