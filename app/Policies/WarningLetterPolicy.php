<?php

namespace App\Policies;

use App\Models\WarningLetter;
use App\Models\User;

class WarningLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, WarningLetter $warningLetter): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->employee?->id === $warningLetter->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, WarningLetter $warningLetter): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, WarningLetter $warningLetter): bool
    {
        return $user->hasRole('admin');
    }
}
