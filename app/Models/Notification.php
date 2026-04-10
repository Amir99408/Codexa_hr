<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'url',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'success' => 'bg-green-100 text-green-600',
            'warning' => 'bg-yellow-100 text-yellow-600',
            'danger'  => 'bg-red-100 text-red-600',
            default   => 'bg-blue-100 text-blue-600',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'success' => '✅',
            'warning' => '⚠️',
            'danger'  => '❌',
            default   => 'ℹ️',
        };
    }
}