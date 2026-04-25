<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        private string $date   = '',
        private string $dept   = '',
        private string $status = '',
    ) {}

    public function query()
    {
        return Attendance::query()
            ->with(['employee.department'])
            ->when($this->date,   fn($q) => $q->whereDate('date', $this->date))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->dept,   fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('department_id', $this->dept)
                )
            )
            ->orderByDesc('date');
    }

    public function headings(): array
    {
        return ['Emp Code', 'Name', 'Department', 'Date', 'Check In', 'Check Out', 'Status', 'Overtime Hours', 'Note'];
    }

    public function map($att): array
    {
        return [
            $att->employee?->emp_code ?? '—',
            $att->employee?->full_name ?? '—',
            $att->employee?->department?->name ?? '—',
            $att->date?->format('Y-m-d'),
            $att->check_in  ?? '—',
            $att->check_out ?? '—',
            ucfirst(str_replace('_', ' ', $att->status)),
            $att->overtime_hours ?? 0,
            $att->note ?? '',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
