<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarningLetter extends Model
{
    protected $fillable = [
        'employee_id',
        'issued_by',
        'type',
        'subject',
        'body',
        'issued_date',
        'severity',
        'employee_acknowledged',
        'acknowledged_at',
    ];

    protected $casts = [
        'issued_date'           => 'date',
        'acknowledged_at'       => 'datetime',
        'employee_acknowledged' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'major' => 'bg-orange-100 text-orange-700',
            'final' => 'bg-red-100 text-red-700',
            default => 'bg-yellow-100 text-yellow-700',
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'misconduct'  => 'bg-red-50 text-red-600',
            'performance' => 'bg-purple-50 text-purple-600',
            'late'        => 'bg-orange-50 text-orange-600',
            'absence'     => 'bg-yellow-50 text-yellow-600',
            default       => 'bg-gray-50 text-gray-600',
        };
    }
}