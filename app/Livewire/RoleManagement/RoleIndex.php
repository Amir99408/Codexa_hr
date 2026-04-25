<?php

namespace App\Livewire\RoleManagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleIndex extends Component
{
    use WithPagination;

    public string $search  = '';
    public string $message = '';

    public ?int   $editUserId   = null;
    public array  $selectedRoles = [];
    public bool   $showModal     = false;

    public function openEdit(int $userId): void
    {
        Gate::authorize('manage-settings');

        $user = User::findOrFail($userId);
        $this->editUserId    = $userId;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->showModal     = true;
    }

    public function save(): void
    {
        Gate::authorize('manage-settings');

        $user = User::findOrFail($this->editUserId);

        // Prevent removing the last admin
        if (!in_array('admin', $this->selectedRoles) && $user->hasRole('admin')) {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                $this->message = 'Cannot remove the last admin account.';
                return;
            }
        }

        $user->syncRoles($this->selectedRoles);

        $this->showModal = false;
        $this->message   = "Roles updated for {$user->name}.";
    }

    public function render()
    {
        $users = User::query()
            ->with('roles')
            ->when($this->search, fn($q) =>
                $q->where('name',  'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(15);

        $roles = Role::all();

        return view('livewire.role-management.role-index', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('layouts.app', ['title' => 'Role Management']);
    }
}
