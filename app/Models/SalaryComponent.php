<?php

namespace App\Models;

use App\Traits\ClearsCaches;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryComponent extends Model
{
    use HasFactory, ClearsCaches;

    protected static array $cacheKeys = ['salary_components_active'];

    protected $fillable = [
        'name',
        'type',
        'calculation_type',
        'value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value'     => 'decimal:2',
    ];

    public function employeeSalaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }
}