<?php

namespace App\Livewire\Portal;

use App\Models\Advance;
use App\Services\NotificationService;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class EmployeeAdvance extends Component
{
    public string $tab          = 'status';
    public string $total_amount = '';
    public string $repayment_type = 'installment';
    public string $installment_amount = '';
    public string $reason       = '';
    public string $message      = '';

    public function save(): void
    {
        Gate::authorize('create', Advance::class);

        $rules = [
            'total_amount'   => 'required|numeric|min:1',
            'repayment_type' => 'required|in:full,installment',
            'reason'         => 'required|string|min:10',
        ];

        if ($this->repayment_type === 'installment') {
            $rules['installment_amount'] = 'required|numeric|min:1|lte:total_amount';
        }

        $this->validate($rules);

        $employee = auth()->user()->employee;
        abort_unless($employee, 403);

        // Check no active/pending advance
        $existing = Advance::where('employee_id', $employee->id)
            ->whereIn('status', ['pending', 'active'])
            ->first();

        if ($existing) {
            $this->addError('total_amount', 'You already have an active or pending advance.');
            return;
        }

        Advance::create([
            'employee_id'        => $employee->id,
            'total_amount'       => $this->total_amount,
            'installment_amount' => $this->repayment_type === 'installment' ? $this->installment_amount : null,
            'paid_amount'        => 0,
            'remaining_amount'   => $this->total_amount,
            'repayment_type'     => $this->repayment_type,
            'start_month'        => now()->month,
            'start_year'         => now()->year,
            'status'             => 'pending',
            'reason'             => $this->reason,
        ]);

        NotificationService::notifyAdmins(
            title: 'New Advance Request 💰',
            message: "{$employee->full_name} requested an advance of " . currency($this->total_amount),
            type: 'info',
            url: '/advances',
        );

        $this->reset(['total_amount','repayment_type','installment_amount','reason']);
        $this->repayment_type = 'installment';
        $this->message        = 'Advance request submitted successfully!';
        $this->tab            = 'status';
    }

    public function render()
    {
        $employee = auth()->user()->employee;

        $advances = Advance::where('employee_id', $employee?->id)
            ->latest()
            ->get();

        $activeAdvance = $advances->where('status', 'active')->first();

        return view('livewire.portal.employee-advance', [
            'advances'      => $advances,
            'activeAdvance' => $activeAdvance,
        ])->layout('layouts.portal', ['title' => 'My Advance']);
    }
}