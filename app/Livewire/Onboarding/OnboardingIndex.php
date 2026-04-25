<?php

namespace App\Livewire\Onboarding;

use App\Models\Employee;
use App\Models\OnboardingTask;
use App\Services\AuditService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class OnboardingIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'onboarding'; // onboarding | probation | all
    public string $message = '';

    // Task modal
    public bool $showTaskModal = false;
    public ?int $selectedEmployeeId = null;

    // Custom task form
    public string $newTask = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilter(): void { $this->resetPage(); }

    public function openTasks(int $employeeId): void
    {
        $this->selectedEmployeeId = $employeeId;
        $this->newTask = '';
        $this->showTaskModal = true;
    }

    public function toggleTask(int $taskId): void
    {
        $task = OnboardingTask::findOrFail($taskId);
        $task->update([
            'is_complete'  => ! $task->is_complete,
            'completed_at' => $task->is_complete ? null : now(),
        ]);
    }

    public function addTask(): void
    {
        $this->validate(['newTask' => 'required|string|max:255']);

        $max = OnboardingTask::where('employee_id', $this->selectedEmployeeId)->max('sort_order') ?? 0;

        OnboardingTask::create([
            'employee_id' => $this->selectedEmployeeId,
            'task'        => $this->newTask,
            'sort_order'  => $max + 1,
        ]);

        $this->newTask = '';
        $this->message = 'Task added.';
    }

    public function deleteTask(int $taskId): void
    {
        OnboardingTask::findOrFail($taskId)->delete();
    }

    public function confirmEmployee(int $employeeId): void
    {
        Gate::authorize('manage-employees');

        $employee = Employee::findOrFail($employeeId);
        $employee->update([
            'onboarding_status' => 'confirmed',
            'status'            => 'active',
        ]);

        AuditService::log(
            action: 'updated',
            model: 'Employee',
            description: "Employee {$employee->full_name} confirmed after probation",
            modelId: $employee->id,
        );

        $this->message = "{$employee->full_name} has been confirmed!";
    }

    public function render()
    {
        $employees = Employee::query()
            ->with(['department', 'onboardingTasks'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('emp_code', 'like', "%{$this->search}%");
            }))
            ->when($this->filter !== 'all', fn($q) => $q->where('onboarding_status', $this->filter))
            ->latest()
            ->paginate(15);

        $selectedEmployee = $this->selectedEmployeeId
            ? Employee::with(['onboardingTasks' => fn($q) => $q->orderBy('sort_order')])->find($this->selectedEmployeeId)
            : null;

        return view('livewire.onboarding.onboarding-index', [
            'employees'        => $employees,
            'selectedEmployee' => $selectedEmployee,
        ])->layout('layouts.app', ['title' => 'Onboarding']);
    }
}
