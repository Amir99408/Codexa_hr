<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Livewire\Component;

class EmployeeChangePassword extends Component
{
    public string $current_password    = '';
    public string $new_password        = '';
    public string $new_password_confirmation = '';
    public string $message             = '';
    public string $messageType         = 'success';

    public function save(): void
    {
        $this->validate([
            'current_password'         => 'required|string',
            'new_password'             => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $user->update(['password' => $this->new_password]);

        $this->current_password         = '';
        $this->new_password             = '';
        $this->new_password_confirmation = '';
        $this->message                  = 'Password changed successfully.';
        $this->messageType              = 'success';
    }

    public function render()
    {
        return view('livewire.portal.employee-change-password')
            ->layout('layouts.portal', ['title' => 'Change Password']);
    }
}
