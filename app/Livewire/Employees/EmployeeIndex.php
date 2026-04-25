<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterDept = '';
    public string $filterStatus = '';
    public ?int $deleteId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    public function deleteEmployee(): void
    {
        Employee::findOrFail($this->deleteId)->delete();
        $this->deleteId = null;
        session()->flash('success', 'Employee deleted successfully.');
    }

    public function export(): void
    {
        $this->redirect(route('export.employees', [
            'search' => $this->search,
            'dept'   => $this->filterDept,
            'status' => $this->filterStatus,
        ]));
    }

    public function render()
    {
        $employees = Employee::query()
            ->with('department')
            ->when($this->search, fn($q) =>
                $q->where('first_name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name', 'like', '%'.$this->search.'%')
                  ->orWhere('emp_code', 'like', '%'.$this->search.'%')
            )
            ->when($this->filterDept, fn($q) =>
                $q->where('department_id', $this->filterDept)
            )
            ->when($this->filterStatus, fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->latest()
            ->paginate(10);

        $departments = Department::all();

        return view('livewire.employees.employee-index', [
            'employees'   => $employees,
            'departments' => $departments,
        ])->layout('layouts.app', ['title' => 'Employees']);
    }
}