<?php

namespace App\Models;

use App\Traits\ClearsCaches;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory, ClearsCaches;

    protected static array $cacheKeys = ['leave_types_all'];

    protected $fillable = [
        'name',
        'days_allowed',
        'carry_forward',
        'is_paid',
        'color',
    ];

    protected $casts = [
        'carry_forward' => 'boolean',
        'is_paid'       => 'boolean',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}