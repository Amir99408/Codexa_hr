<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftAssignment extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_id',
        'date',
        'note',
    ];

    // ✅ This is the fix — cast date to Y-m-d string so firstWhere() matches
    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    // App\Models\ShiftAssignment.php
public function assignedBy()
{
    return $this->belongsTo(User::class, 'assigned_by'); // assuming you store assigned_by in the table
}
}