<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingTask extends Model
{
    protected $fillable = ['employee_id', 'task', 'is_complete', 'completed_at', 'sort_order'];

    protected $casts = ['is_complete' => 'boolean', 'completed_at' => 'datetime'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
