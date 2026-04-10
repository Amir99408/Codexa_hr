<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_postings';

    protected $fillable = [
        'title',
        'department_id',
        'description',
        'requirements',
        'location',
        'type',
        'salary_min',
        'salary_max',
        'positions',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline'   => 'date',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'job_posting_id');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open'    => 'bg-green-100 text-green-700',
            'closed'  => 'bg-red-100 text-red-700',
            'on_hold' => 'bg-yellow-100 text-yellow-700',
            default   => 'bg-gray-100 text-gray-600',
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'full_time'  => 'bg-blue-100 text-blue-700',
            'part_time'  => 'bg-purple-100 text-purple-700',
            'contract'   => 'bg-orange-100 text-orange-700',
            'internship' => 'bg-teal-100 text-teal-700',
            default      => 'bg-gray-100 text-gray-600',
        };
    }
}