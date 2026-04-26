<?php

namespace App\Livewire\Attendance;

use App\Models\AttendanceDeviceLog;
use Livewire\Component;
use Livewire\WithPagination;

class DeviceLogs extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $search       = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function render()
    {
        $logs = AttendanceDeviceLog::query()
            ->with('employee')
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->search, fn($q) =>
                $q->where('employee_code', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(20);

        $stats = [
            'total'     => AttendanceDeviceLog::count(),
            'matched'   => AttendanceDeviceLog::where('status', 'matched')->count(),
            'unmatched' => AttendanceDeviceLog::where('status', 'unmatched')->count(),
            'duplicate' => AttendanceDeviceLog::where('status', 'duplicate')->count(),
        ];

        return view('livewire.attendance.device-logs', compact('logs', 'stats'))
            ->layout('layouts.app', ['title' => 'Device Sync Logs']);
    }
}
