<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'color',
        'description',
        'is_active',
    ];

    public function assignments()
    {
        return $this->hasMany(ShiftAssignment::class);
    }

    public function getDurationAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end   = \Carbon\Carbon::parse($this->end_time);
        $hours = $start->diffInHours($end);
        return $hours . 'h';
    }
}