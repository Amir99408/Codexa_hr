<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'employee_id', 'title', 'category', 'file_path', 'file_name', 'expiry_date', 'is_verified',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_verified' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return $this->expiry_date && ! $this->expiry_date->isPast()
            && $this->expiry_date->diffInDays(now()) <= 30;
    }
}
