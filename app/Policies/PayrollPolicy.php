<?php

namespace App\Policies;

use App\Models\Payroll;
use App\Models\User;

class PayrollPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Payroll $payroll): bool
    {
        if ($user->hasRole('admin')) return true;

        return $user->employee?->id === $payroll->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Payroll $payroll): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Payroll $payroll): bool
    {
        return $user->hasRole('admin');
    }
}
