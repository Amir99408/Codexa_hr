<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmployeeUpdatePhoto extends Component
{
    use WithFileUploads;

    public $photo = null;
    public string $message     = '';
    public string $messageType = 'success';

    public function updatedPhoto(): void
    {
        $this->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    public function save(): void
    {
        $this->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $employee = auth()->user()->employee;

        if (! $employee) {
            $this->message     = 'No employee profile linked to your account.';
            $this->messageType = 'error';
            return;
        }

        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        $path = $this->photo->store('photos/employees', 'public');
        $employee->update(['photo' => $path]);

        $this->photo       = null;
        $this->message     = 'Profile photo updated successfully.';
        $this->messageType = 'success';
    }

    public function removePhoto(): void
    {
        $employee = auth()->user()->employee;

        if (! $employee) {
            return;
        }

        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->update(['photo' => null]);
        $this->photo       = null;
        $this->message     = 'Profile photo removed.';
        $this->messageType = 'success';
    }

    public function render()
    {
        return view('livewire.portal.employee-update-photo')
            ->layout('layouts.portal', ['title' => 'Update Photo']);
    }
}
