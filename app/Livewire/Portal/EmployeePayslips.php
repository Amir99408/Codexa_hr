<?php

namespace App\Livewire\Portal;

use App\Models\Payroll;
use Livewire\Component;

class EmployeePayslips extends Component
{
    public ?int $viewingId = null;

    public function render()
    {
        $employee = auth()->user()->employee;

        $payslips = $employee
            ? Payroll::where('employee_id', $employee->id)
                ->whereIn('status', ['processed', 'paid'])
                ->with('items')
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->get()
            : collect();

        $viewing = $this->viewingId
            ? Payroll::with(['items', 'employee.department'])->find($this->viewingId)
            : null;

        return view('livewire.portal.employee-payslips', [
            'payslips' => $payslips,
            'viewing'  => $viewing,
        ])->layout('layouts.portal', ['title' => 'My Payslips']);
    }
}
