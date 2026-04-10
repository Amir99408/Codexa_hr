<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'job_posting_id',
        'name',
        'email',
        'phone',
        'cv_path',
        'stage',
        'rating',
        'notes',
        'interview_date',
        'interview_time',
        'interviewer_id',
    ];

    protected $casts = [
        'interview_date' => 'date',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_posting_id');
    }

    public function interviewer()
    {
        return $this->belongsTo(Employee::class, 'interviewer_id');
    }

    public function getStageColorAttribute(): string
    {
        return match($this->stage) {
            'applied'   => 'bg-gray-100 text-gray-700',
            'screening' => 'bg-blue-100 text-blue-700',
            'interview' => 'bg-purple-100 text-purple-700',
            'offer'     => 'bg-orange-100 text-orange-700',
            'hired'     => 'bg-green-100 text-green-700',
            'rejected'  => 'bg-red-100 text-red-700',
            default     => 'bg-gray-100 text-gray-600',
        };
    }
}