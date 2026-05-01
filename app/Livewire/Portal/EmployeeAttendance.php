<?php

namespace App\Livewire\Portal;

use App\Models\Attendance;
use App\Models\Holiday;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
            ->get()
            ->keyBy(fn($a) => $a->date->format('Y-m-d'));

        $start    = Carbon::create($this->selectedYear, $this->selectedMonth, 1);
        $end      = $start->copy()->endOfMonth();
        $holidays = Holiday::whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->flip();

        $calendar = [];
        foreach (CarbonPeriod::create($start, $end) as $date) {
            $key = $date->format('Y-m-d');
            if ($date->isWeekend()) {
                $calendar[] = ['date' => $date->copy(), 'type' => 'weekend', 'record' => null];
            } elseif (isset($holidays[$key])) {
                $calendar[] = ['date' => $date->copy(), 'type' => 'holiday', 'record' => null];
            } elseif ($date->greaterThan(now())) {
                $calendar[] = ['date' => $date->copy(), 'type' => 'future', 'record' => null];
            } else {
                $calendar[] = ['date' => $date->copy(), 'type' => 'workday', 'record' => $attendances[$key] ?? null];
            }
        }

        $summary = [
            'present'  => $attendances->whereIn('status', ['present', 'work_from_home'])->count(),
            'absent'   => $attendances->where('status', 'absent')->count(),
            'late'     => $attendances->where('status', 'late')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
        ];

        return view('livewire.portal.employee-attendance', [
            'calendar' => $calendar,
            'summary'  => $summary,
        ])->layout('layouts.portal', ['title' => 'My Attendance']);
    }
}