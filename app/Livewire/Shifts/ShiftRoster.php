<?php

namespace App\Livewire\Shifts;

use App\Models\Shift;
use App\Models\ShiftAssignment;
use App\Models\Employee;
use App\Services\NotificationService;
use Livewire\Component;
use Carbon\Carbon;

class ShiftRoster extends Component
{
    public int $selectedMonth;
    public int $selectedYear;

    // Employees collection
    public $employees;

    // Assignment modal
    public bool   $showModal    = false;
    public ?int   $employee_id  = null;
    public ?int   $shift_id     = null;
    public string $date         = '';
    public string $note         = '';
    public string $message      = '';

    protected $listeners = ['refreshRoster' => '$refresh'];

   public function mount(): void
{
    $this->selectedMonth = now()->month;
    $this->selectedYear  = now()->year;

    $this->loadEmployees();
}

    // Load employees and their shift assignments
    public function loadEmployees()
{
    $this->employees = Employee::where('status', 'active')
        ->with(['shiftAssignments' => fn($q) =>
            $q->whereMonth('date', $this->selectedMonth)
              ->whereYear('date', $this->selectedYear)
              ->with('shift', 'assignedBy')
        ])
        ->get();
}

    // Open assignment modal
    public function openAssign(string $date, ?int $employeeId = null): void
    {
        $this->date        = $date;
        $this->employee_id = $employeeId;
        $this->shift_id    = null;
        $this->note        = '';
        $this->showModal   = true;
    }

    // Save assignment
    public function save(): void
{
    $this->validate([
        'employee_id' => 'required|exists:employees,id',
        'shift_id'    => 'required|exists:shifts,id',
        'date'        => 'required|date',
    ]);

    ShiftAssignment::updateOrCreate(
        ['employee_id' => $this->employee_id, 'date' => $this->date],
        ['shift_id' => $this->shift_id, 'note' => $this->note]
    );

    NotificationService::notifyEmployee(
        employeeId: $this->employee_id,
        title: 'Shift Assigned 📅',
        message: "You have been assigned a shift on " . Carbon::parse($this->date)->format('d M Y'),
        type: 'info',
    );

    $this->loadEmployees(); // 🔹 refresh collection

    $this->showModal = false;
    $this->message   = 'Shift assigned!';
}

    // Remove assignment
    public function removeAssignment(int $id): void
    {
        ShiftAssignment::destroy($id);
        $this->message = 'Assignment removed.';
        $this->loadEmployees(); // Refresh table
    }

    public function render()
    {
        $startOfMonth = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1);
        $daysInMonth  = $startOfMonth->daysInMonth;

        $shifts = Shift::where('is_active', true)->get();

        return view('livewire.shifts.shift-roster', [
            'employees'    => $this->employees,
            'shifts'       => $shifts,
            'daysInMonth'  => $daysInMonth,
            'startOfMonth' => $startOfMonth,
        ])->layout('layouts.app', ['title' => 'Shift Roster']);
    }
}