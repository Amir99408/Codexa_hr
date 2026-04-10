<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class AttendanceIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterDate   = '';
    public string $filterDept   = '';
    public string $filterStatus = '';
    public string $message      = '';

    // Bulk mark attendance
    public bool $showMarkModal    = false;
    public string $markDate       = '';
    public string $markStatus     = 'present';
    public string $markCheckIn    = '09:00';
    public string $markCheckOut   = '18:00';
    public ?int $markEmployeeId   = null;

    public function mount(): void
    {
        $this->filterDate = today()->format('Y-m-d');
        $this->markDate   = today()->format('Y-m-d');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Open mark modal for single employee
    public function openMark(?int $employeeId = null): void
    {
        $this->markEmployeeId = $employeeId;
        $this->markDate       = today()->format('Y-m-d');
        $this->markStatus     = 'present';
        $this->markCheckIn    = '09:00';
        $this->markCheckOut   = '18:00';
        $this->showMarkModal  = true;
    }

    // Save attendance
    public function markAttendance(): void
    {
        $this->validate([
            'markDate'     => 'required|date',
            'markStatus'   => 'required|in:present,absent,late,half_day,work_from_home',
            'markCheckIn'  => 'nullable',
            'markCheckOut' => 'nullable',
        ]);

        $employees = $this->markEmployeeId
            ? Employee::where('id', $this->markEmployeeId)->where('status', 'active')->get()
            : Employee::where('status', 'active')->get();

        foreach ($employees as $employee) {
            Attendance::updateOrCreate(
                ['employee_id' => $employee->id, 'date' => Carbon::parse($this->markDate)->format('Y-m-d')],
                [
                    'status'    => $this->markStatus,
                    'check_in'  => in_array($this->markStatus, ['present', 'late', 'half_day', 'work_from_home'])
                                    ? $this->markCheckIn : null,
                    'check_out' => in_array($this->markStatus, ['present', 'late', 'half_day', 'work_from_home'])
                                    ? $this->markCheckOut : null,
                ]
            );
        }

        $this->showMarkModal  = false;
        $this->message        = 'Attendance marked successfully.';
    }

    // Delete attendance record
    public function deleteAttendance(int $id): void
    {
        Attendance::findOrFail($id)->delete();
        $this->message = 'Attendance record deleted.';
    }

    public function render()
    {
        $attendances = Attendance::query()
            ->with(['employee.department'])
            ->when($this->filterDate, fn($q) =>
                $q->whereDate('date', $this->filterDate)
            )
            ->when($this->filterStatus, fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->when($this->filterDept, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('department_id', $this->filterDept)
                )
            )
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', '%'.$this->search.'%')
                       ->orWhere('last_name',  'like', '%'.$this->search.'%')
                       ->orWhere('emp_code',   'like', '%'.$this->search.'%')
                )
            )
            ->latest('date')
            ->paginate(15);

        $departments   = Department::all();
        $todayTotal    = Employee::where('status', 'active')->count();
        $todayPresent  = Attendance::whereDate('date', today())->where('status', 'present')->count();
        $todayAbsent   = Attendance::whereDate('date', today())->where('status', 'absent')->count();
        $todayLate     = Attendance::whereDate('date', today())->where('status', 'late')->count();

        return view('livewire.attendance.attendance-index', [
            'attendances'  => $attendances,
            'departments'  => $departments,
            'todayTotal'   => $todayTotal,
            'todayPresent' => $todayPresent,
            'todayAbsent'  => $todayAbsent,
            'todayLate'    => $todayLate,
        ])->layout('layouts.app', ['title' => 'Attendance']);
    }
}

