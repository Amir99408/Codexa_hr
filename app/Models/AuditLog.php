<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Action badge color
    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created'  => 'bg-green-100 text-green-700',
            'updated'  => 'bg-blue-100 text-blue-700',
            'deleted'  => 'bg-red-100 text-red-700',
            'approved' => 'bg-emerald-100 text-emerald-700',
            'rejected' => 'bg-orange-100 text-orange-700',
            'login'    => 'bg-purple-100 text-purple-700',
            'logout'   => 'bg-gray-100 text-gray-700',
            'paid'     => 'bg-teal-100 text-teal-700',
            default    => 'bg-gray-100 text-gray-600',
        };
    }
}
