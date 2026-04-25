<?php

namespace App\Policies;

use App\Models\Leave;
use App\Models\User;

class LeavePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Leave $leave): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->employee?->id === $leave->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->employee !== null;
    }

    public function update(User $user, Leave $leave): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Leave $leave): bool
    {
        return $user->hasRole('admin');
    }
}
