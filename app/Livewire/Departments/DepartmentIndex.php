<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentIndex extends Component
{
    use WithPagination;

    public string $search = '';

    // Form fields
    public string $message = '';
    public string $name = '';
    public string $code = '';
    public ?int $editId = null;
    public ?int $deleteId = null;
    public bool $showForm = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Open blank form for create
    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editId = null;
    }

    // Open form filled for edit
    public function edit(int $id): void
    {
        $dept = Department::findOrFail($id);
        $this->editId = $id;
        $this->name   = $dept->name;
        $this->code   = $dept->code ?? '';
        $this->showForm = true;
    }

    // Save or update
    public function save(): void
{
    $this->validate([
        'name' => 'required|string|max:100',
        'code' => 'nullable|string|max:20',
    ]);

    if ($this->editId) {
        Department::findOrFail($this->editId)->update([
            'name' => $this->name,
            'code' => $this->code,
        ]);
        $this->message = 'Department updated successfully.';
    } else {
        Department::create([
            'name' => $this->name,
            'code' => $this->code,
        ]);
        $this->message = 'Department created successfully.';
    }

    $this->resetForm();
    $this->showForm = false;
}

    // Confirm delete
    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    // Delete department
   public function delete(): void
{
    $dept = Department::findOrFail($this->deleteId);

    if ($dept->employees()->count() > 0) {
        $this->message = 'Cannot delete department with employees.';
        $this->deleteId = null;
        return;
    }

    $dept->delete();
    $this->deleteId = null;
    $this->message = 'Department deleted successfully.';
}

    // Reset form fields
    public function resetForm(): void
    {
        $this->name   = '';
        $this->code   = '';
        $this->editId = null;
    }

    public function render()
    {
        $departments = Department::query()
            ->withCount('employees')
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('code', 'like', '%'.$this->search.'%')
            )
            ->latest()
            ->paginate(10);

        return view('livewire.departments.department-index', [
            'departments' => $departments,
        ])->layout('layouts.app', ['title' => 'Departments']);
    }
}

