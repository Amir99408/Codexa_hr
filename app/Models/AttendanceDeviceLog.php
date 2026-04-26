<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDeviceLog extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_code',
        'punch_time',
        'punch_type',
        'device_serial',
        'status',
        'raw_data',
    ];

    protected $casts = [
        'punch_time' => 'datetime',
        'raw_data'   => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
