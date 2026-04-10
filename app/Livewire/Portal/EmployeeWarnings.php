<?php

namespace App\Livewire\Portal;

use App\Models\WarningLetter;
use Livewire\Component;

class EmployeeWarnings extends Component
{
    public ?int $viewingId = null;

    public function acknowledge(int $id): void
    {
        WarningLetter::where('id', $id)
            ->where('employee_id', auth()->user()->employee?->id)
            ->update([
                'employee_acknowledged' => true,
                'acknowledged_at'       => now(),
            ]);
    }

    public function render()
    {
        $employee = auth()->user()->employee;

        $letters = WarningLetter::where('employee_id', $employee?->id)
            ->with('issuedBy')
            ->latest()
            ->get();

        $viewing = $this->viewingId
            ? WarningLetter::with(['employee', 'issuedBy'])->find($this->viewingId)
            : null;

        return view('livewire.portal.employee-warnings', [
            'letters' => $letters,
            'viewing' => $viewing,
        ])->layout('layouts.portal', ['title' => 'My Warnings']);
    }
}