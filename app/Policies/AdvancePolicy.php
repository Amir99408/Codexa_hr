<?php

namespace App\Policies;

use App\Models\Advance;
use App\Models\User;

class AdvancePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Advance $advance): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->employee?->id === $advance->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->employee !== null || $user->hasRole('admin');
    }

    public function update(User $user, Advance $advance): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Advance $advance): bool
    {
        return $user->hasRole('admin');
    }
}
