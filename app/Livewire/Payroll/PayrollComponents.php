<?php

namespace App\Livewire\Payroll;

use App\Models\SalaryComponent;
use Livewire\Component;

class PayrollComponents extends Component
{
    public string $name             = '';
    public string $type             = 'earning';
    public string $calculation_type = 'flat';
    public string $value            = '';
    public bool   $is_active        = true;
    public ?int   $editId           = null;
    public ?int   $deleteId         = null;
    public bool   $showForm         = false;
    public string $message          = '';

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $comp                   = SalaryComponent::findOrFail($id);
        $this->editId           = $id;
        $this->name             = $comp->name;
        $this->type             = $comp->type;
        $this->calculation_type = $comp->calculation_type;
        $this->value            = $comp->value;
        $this->is_active        = $comp->is_active;
        $this->showForm         = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'             => 'required|string|max:100',
            'type'             => 'required|in:earning,deduction',
            'calculation_type' => 'required|in:flat,percentage',
            'value'            => [
                'required',
                'numeric',
                'min:0',
                // Cap percentage-based components at 100 % to prevent invalid salary inflation
                $this->calculation_type === 'percentage' ? 'max:100' : 'max:9999999',
            ],
        ]);

        if ($this->editId) {
            SalaryComponent::findOrFail($this->editId)->update([
                'name'             => $this->name,
                'type'             => $this->type,
                'calculation_type' => $this->calculation_type,
                'value'            => $this->value,
                'is_active'        => $this->is_active,
            ]);
            $this->message = 'Component updated.';
        } else {
            SalaryComponent::create([
                'name'             => $this->name,
                'type'             => $this->type,
                'calculation_type' => $this->calculation_type,
                'value'            => $this->value,
                'is_active'        => $this->is_active,
            ]);
            $this->message = 'Component created.';
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    public function delete(): void
    {
        SalaryComponent::findOrFail($this->deleteId)->delete();
        $this->deleteId = null;
        $this->message  = 'Component deleted.';
    }

    private function resetForm(): void
    {
        $this->name             = '';
        $this->type             = 'earning';
        $this->calculation_type = 'flat';
        $this->value            = '';
        $this->is_active        = true;
        $this->editId           = null;
    }

    public function render()
    {
        return view('livewire.payroll.payroll-components', [
            'components' => SalaryComponent::latest()->get(),
        ])->layout('layouts.app', ['title' => 'Salary Components']);
    }
}