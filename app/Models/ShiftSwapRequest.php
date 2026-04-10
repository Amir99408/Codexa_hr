<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftSwapRequest extends Model
{
    protected $fillable = [
        'requester_id',
        'requested_id',
        'requester_assignment_id',
        'requested_assignment_id',
        'reason',
        'status',
        'approved_by',
    ];

    public function requester()
    {
        return $this->belongsTo(Employee::class, 'requester_id');
    }

    public function requested()
    {
        return $this->belongsTo(Employee::class, 'requested_id');
    }

    public function requesterAssignment()
    {
        return $this->belongsTo(ShiftAssignment::class, 'requester_assignment_id');
    }

    public function requestedAssignment()
    {
        return $this->belongsTo(ShiftAssignment::class, 'requested_assignment_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default    => 'bg-yellow-100 text-yellow-700',
        };
    }
}