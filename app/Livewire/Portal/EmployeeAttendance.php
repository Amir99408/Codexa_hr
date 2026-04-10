<?php

namespace App\Livewire\Portal;

use App\Models\Attendance;
use Livewire\Component;

class EmployeeAttendance extends Component
{
    public int $selectedMonth;
    public int $selectedYear;

    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear  = now()->year;
    }

    public function render()
    {
        $employee = auth()->user()->employee;

        $attendances = Attendance::where('employee_id', $employee?->id)
            ->whereMonth('date', $this->selectedMonth)
            ->whereYear('date',  $this->selectedYear)
            ->orderBy('date')
            ->get();

        $summary = [
            'present'  => $attendances->whereIn('status', ['present', 'work_from_home'])->count(),
            'absent'   => $attendances->where('status', 'absent')->count(),
            'late'     => $attendances->where('status', 'late')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
        ];

        return view('livewire.portal.employee-attendance', [
            'attendances' => $attendances,
            'summary'     => $summary,
        ])->layout('layouts.portal', ['title' => 'My Attendance']);
    }
}