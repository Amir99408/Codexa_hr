<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        private string $search = '',
        private string $dept   = '',
        private string $status = '',
    ) {}

    public function query()
    {
        return Employee::query()
            ->with('department')
            ->when($this->search, fn($q) =>
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name',  'like', "%{$this->search}%")
                  ->orWhere('emp_code',   'like', "%{$this->search}%")
            )
            ->when($this->dept,   fn($q) => $q->where('department_id', $this->dept))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('first_name');
    }

    public function headings(): array
    {
        return ['Code', 'First Name', 'Last Name', 'Department', 'Designation', 'Gender', 'Phone', 'Join Date', 'Basic Salary', 'Status'];
    }

    public function map($employee): array
    {
        return [
            $employee->emp_code,
            $employee->first_name,
            $employee->last_name,
            $employee->department?->name ?? '—',
            $employee->designation ?? '—',
            $employee->gender ?? '—',
            $employee->phone ?? '—',
            $employee->join_date?->format('Y-m-d') ?? '—',
            $employee->basic_salary,
            $employee->status,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
