<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'total_earnings',
        'total_deductions',
        'gross_salary',
        'net_salary',
        'working_days',
        'present_days',
        'absent_days',
        'advance_deduction',
        'advance_id',
        'status',
        'note',
    ];

    protected $casts = [
        'basic_salary'      => 'decimal:2',
        'total_earnings'    => 'decimal:2',
        'total_deductions'  => 'decimal:2',
        'gross_salary'      => 'decimal:2',
        'net_salary'        => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'present_days'      => 'decimal:1',
        'absent_days'       => 'decimal:1',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function getMonthNameAttribute(): string
    {
        return \Carbon\Carbon::createFromDate($this->year, $this->month, 1)
            ->format('F Y');
    }
}