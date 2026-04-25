<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'emp_code',
        'first_name',
        'last_name',
        'phone',
        'designation',
        'gender',
        'date_of_birth',
        'join_date',
        'basic_salary',
        'status',
        'address',
        'photo',
        'onboarding_status',
        'probation_end_date',
    ];

    protected $casts = [
        'date_of_birth'      => 'date',
        'join_date'          => 'date',
        'basic_salary'       => 'decimal:2',
        'probation_end_date' => 'date',
    ];

    // Full name helper
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Belongs to a department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Belongs to a user account
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function employeeSalaries()
{
    return $this->hasMany(EmployeeSalary::class);
}
public function shiftAssignments()
{
    return $this->hasMany(ShiftAssignment::class);
}
public function getPhotoUrlAttribute(): ?string
{
    return $this->photo
        ? asset('storage/' . $this->photo)
        : null;
}

public function onboardingTasks()
{
    return $this->hasMany(OnboardingTask::class);
}

public function documents()
{
    return $this->hasMany(EmployeeDocument::class);
}
}