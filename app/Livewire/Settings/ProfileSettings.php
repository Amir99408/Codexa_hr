<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads;

class ProfileSettings extends Component
{
    use WithFileUploads;

    public string $name             = '';
    public string $email            = '';
    public string $current_password = '';
    public string $new_password     = '';
    public string $new_password_confirmation = '';
    public string $message          = '';
    public string $passwordMessage  = '';
    public $new_photo = null;

    public function mount(): void
    {
        $this->name  = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updatedNewPhoto(): void
    {
        $this->validate([
            'new_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $path = $this->new_photo->store('photos/users', 'public');

        if ($user->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
        }

        $user->photo = $path;
        $user->save();

        $this->reset('new_photo');

        $this->redirect(route('settings.profile'), navigate: false);
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        $this->message = 'Profile updated successfully.';
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => 'required',
            'new_password'     => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        Auth::user()->update([
            'password' => $this->new_password,
        ]);

        $this->current_password          = '';
        $this->new_password              = '';
        $this->new_password_confirmation = '';
        $this->passwordMessage           = 'Password changed successfully.';
    }

    public function render()
    {
        return view('livewire.settings.profile-settings')
            ->layout('layouts.app', ['title' => 'Profile Settings']);
    }
}
