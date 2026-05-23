<?php

namespace App\Livewire\Tracking;

use App\Models\Employee;
use App\Models\EmployeeLocation;
use Carbon\Carbon;
use Livewire\Component;

class TrackingDashboard extends Component
{
    public string $mode          = 'live';   // 'live' | 'history'
    public ?int   $historyEmpId  = null;
    public string $historyDate   = '';

    public function mount(): void
    {
        $this->historyDate = today()->toDateString();
    }

    private function liveData(): array
    {
        // Latest ping per employee within last 60 minutes
        $cutoff = now()->subMinutes(60);

        $latest = EmployeeLocation::selectRaw('MAX(id) as id')
            ->where('recorded_at', '>=', $cutoff)
            ->groupBy('employee_id')
            ->pluck('id');

        return EmployeeLocation::with('employee')
            ->whereIn('id', $latest)
            ->get()
            ->map(fn($loc) => [
                'id'       => $loc->employee_id,
                'name'     => $loc->employee->full_name,
                'initials' => $loc->employee->initials ?? strtoupper(substr($loc->employee->first_name, 0, 1)),
                'lat'      => (float) $loc->latitude,
                'lng'      => (float) $loc->longitude,
                'accuracy' => $loc->accuracy,
                'time'     => $loc->recorded_at->diffForHumans(),
                'dept'     => $loc->employee->department?->name ?? '',
            ])
            ->values()
            ->all();
    }

    private function historyData(): array
    {
        if (! $this->historyEmpId || ! $this->historyDate) {
            return [];
        }

        return EmployeeLocation::where('employee_id', $this->historyEmpId)
            ->whereBetween('recorded_at', [
                Carbon::parse($this->historyDate)->startOfDay(),
                Carbon::parse($this->historyDate)->endOfDay(),
            ])
            ->orderBy('recorded_at')
            ->get()
            ->map(fn($loc) => [
                'lat'  => (float) $loc->latitude,
                'lng'  => (float) $loc->longitude,
                'time' => $loc->recorded_at->format('H:i'),
            ])
            ->values()
            ->all();
    }

    public function render()
    {
        $employees = Employee::where('status', 'active')
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name']);

        $liveData    = $this->mode === 'live'    ? $this->liveData()    : [];
        $historyData = $this->mode === 'history' ? $this->historyData() : [];

        $historyEmployee = $this->historyEmpId
            ? Employee::find($this->historyEmpId)
            : null;

        return view('livewire.tracking.tracking-dashboard', [
            'employees'       => $employees,
            'liveData'        => $liveData,
            'historyData'     => $historyData,
            'historyEmployee' => $historyEmployee,
            'liveJson'        => json_encode($liveData),
            'historyJson'     => json_encode($historyData),
        ])->layout('layouts.app', ['title' => 'Location Tracking']);
    }
}
