<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceReview extends Model
{
    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'cycle',
        'period_type',
        'year',
        'overall_score',
        'strengths',
        'improvements',
        'goals_next_period',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'overall_score' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function criteria()
    {
        return $this->hasMany(ReviewCriteria::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'submitted'    => 'bg-green-100 text-green-700',
            'acknowledged' => 'bg-blue-100 text-blue-700',
            default        => 'bg-yellow-100 text-yellow-700',
        };
    }

    public function getScoreColorAttribute(): string
    {
        if (!$this->overall_score) return 'text-gray-400';
        return match(true) {
            $this->overall_score >= 4.5 => 'text-green-600',
            $this->overall_score >= 3.5 => 'text-blue-600',
            $this->overall_score >= 2.5 => 'text-yellow-600',
            default                     => 'text-red-500',
        };
    }

    public function getScoreLabelAttribute(): string
    {
        if (!$this->overall_score) return '—';
        return match(true) {
            $this->overall_score >= 4.5 => 'Excellent',
            $this->overall_score >= 3.5 => 'Good',
            $this->overall_score >= 2.5 => 'Average',
            default                     => 'Needs Improvement',
        };
    }
}