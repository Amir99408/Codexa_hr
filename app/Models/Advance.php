<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $fillable = [
        'employee_id',
        'approved_by',
        'total_amount',
        'installment_amount',
        'paid_amount',
        'remaining_amount',
        'repayment_type',
        'start_month',
        'start_year',
        'status',
        'reason',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'total_amount'       => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'paid_amount'        => 'decimal:2',
        'remaining_amount'   => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active'    => 'bg-blue-100 text-blue-700',
            'completed' => 'bg-emerald-100 text-emerald-700',
            'rejected'  => 'bg-red-100 text-red-700',
            default     => 'bg-yellow-100 text-yellow-700',
        };
    }

    public function getMonthlyDeductionAttribute(): float
    {
        if ($this->repayment_type === 'full') {
            return (float) $this->remaining_amount;
        }
        return (float) min($this->installment_amount, $this->remaining_amount);
    }
}