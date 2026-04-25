<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        private int    $month,
        private int    $year,
        private string $dept   = '',
        private string $status = '',
    ) {}

    public function query()
    {
        return Payroll::query()
            ->with(['employee.department'])
            ->where('month', $this->month)
            ->where('year',  $this->year)
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->dept,   fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('department_id', $this->dept)
                )
            )
            ->orderBy('employee_id');
    }

    public function headings(): array
    {
        return [
            'Emp Code', 'Name', 'Department', 'Month', 'Year',
            'Basic Salary', 'Total Earnings', 'Total Deductions',
            'Gross Salary', 'Advance Deduction', 'Net Salary',
            'Working Days', 'Present Days', 'Absent Days', 'Status',
        ];
    }

    public function map($payroll): array
    {
        return [
            $payroll->employee?->emp_code ?? '—',
            $payroll->employee?->full_name ?? '—',
            $payroll->employee?->department?->name ?? '—',
            $payroll->month,
            $payroll->year,
            $payroll->basic_salary,
            $payroll->total_earnings,
            $payroll->total_deductions,
            $payroll->gross_salary,
            $payroll->advance_deduction,
            $payroll->net_salary,
            $payroll->working_days,
            $payroll->present_days,
            $payroll->absent_days,
            ucfirst($payroll->status),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
