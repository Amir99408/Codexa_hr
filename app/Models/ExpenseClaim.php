<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseClaim extends Model
{
    protected $fillable = [
        'employee_id',
        'title',
        'category',
        'amount',
        'expense_date',
        'description',
        'receipt_path',
        'status',
        'approved_by',
        'rejection_reason',
        'approved_at',
        'reimbursed_at',
    ];

    protected $casts = [
        'expense_date'  => 'date',
        'approved_at'   => 'datetime',
        'reimbursed_at' => 'datetime',
        'amount'        => 'decimal:2',
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
            'approved'    => 'bg-green-100 text-green-700',
            'rejected'    => 'bg-red-100 text-red-700',
            'reimbursed'  => 'bg-blue-100 text-blue-700',
            default       => 'bg-yellow-100 text-yellow-700',
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            'travel'        => '✈️',
            'food'          => '🍽️',
            'equipment'     => '💻',
            'accommodation' => '🏨',
            default         => '📄',
        };
    }
}