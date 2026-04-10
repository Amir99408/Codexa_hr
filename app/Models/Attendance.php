<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
    'employee_id',
    'date',
    'check_in',
    'check_out',
    'status',
    'overtime_hours',
    'note',
];

    protected $casts = [
        'date'           => 'date:Y-m-d',
        'overtime_hours' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}