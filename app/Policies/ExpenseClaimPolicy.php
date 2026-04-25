<?php

namespace App\Policies;

use App\Models\ExpenseClaim;
use App\Models\User;

class ExpenseClaimPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ExpenseClaim $expenseClaim): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->employee?->id === $expenseClaim->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->employee !== null || $user->hasRole('admin');
    }

    public function update(User $user, ExpenseClaim $expenseClaim): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, ExpenseClaim $expenseClaim): bool
    {
        return $user->hasRole('admin');
    }
}
