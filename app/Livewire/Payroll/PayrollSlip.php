<?php

namespace App\Livewire\Payroll;

use App\Models\Payroll;
use Livewire\Component;

class PayrollSlip extends Component
{
    public Payroll $payroll;

    public function mount(Payroll $payroll): void
    {
        $this->payroll = $payroll->load(['employee.department', 'items']);
    }

    public function render()
    {
        return view('livewire.payroll.payroll-slip')
            ->layout('layouts.app', ['title' => 'Payslip']);
    }
}
