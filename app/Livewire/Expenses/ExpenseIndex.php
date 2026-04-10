<?php

namespace App\Livewire\Expenses;

use App\Models\ExpenseClaim;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;

class ExpenseIndex extends Component
{
    use WithPagination;

    public string $search         = '';
    public string $filterStatus   = '';
    public string $filterCategory = '';
    public string $message        = '';

    // Reject modal
    public bool   $showRejectModal   = false;
    public ?int   $rejectId          = null;
    public string $rejection_reason  = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function approve(int $id): void
    {
        $claim = ExpenseClaim::with('employee')->findOrFail($id);
        $claim->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        NotificationService::notifyEmployee(
            employeeId: $claim->employee_id,
            title: 'Expense Approved ✅',
            message: "Your expense claim \"{$claim->title}\" of " . currency($claim->amount) . " has been approved.",
            type: 'success',
            url: '/portal/expenses',
        );

        $this->message = 'Expense claim approved.';
    }

    public function openReject(int $id): void
    {
        $this->rejectId        = $id;
        $this->showRejectModal = true;
        $this->rejection_reason = '';
    }

    public function reject(): void
    {
        $this->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $claim = ExpenseClaim::with('employee')->findOrFail($this->rejectId);
        $claim->update([
            'status'           => 'rejected',
            'approved_by'      => auth()->id(),
            'rejection_reason' => $this->rejection_reason,
        ]);

        NotificationService::notifyEmployee(
            employeeId: $claim->employee_id,
            title: 'Expense Rejected ❌',
            message: "Your expense claim \"{$claim->title}\" has been rejected.",
            type: 'danger',
            url: '/portal/expenses',
        );

        $this->reset(['showRejectModal', 'rejectId', 'rejection_reason']);
        $this->message = 'Expense claim rejected.';
    }

    public function markReimbursed(int $id): void
    {
        $claim = ExpenseClaim::with('employee')->findOrFail($id);
        $claim->update([
            'status'        => 'reimbursed',
            'reimbursed_at' => now(),
        ]);

        NotificationService::notifyEmployee(
            employeeId: $claim->employee_id,
            title: 'Expense Reimbursed 💰',
            message: "Your expense claim \"{$claim->title}\" of " . currency($claim->amount) . " has been reimbursed.",
            type: 'success',
            url: '/portal/expenses',
        );

        $this->message = 'Marked as reimbursed.';
    }

    public function render()
    {
        $claims = ExpenseClaim::query()
            ->with(['employee.department', 'approvedBy'])
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterStatus,   fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest()
            ->paginate(15);

        $stats = [
            'total'      => ExpenseClaim::count(),
            'pending'    => ExpenseClaim::where('status', 'pending')->count(),
            'approved'   => ExpenseClaim::where('status', 'approved')->count(),
            'total_amount' => ExpenseClaim::whereIn('status', ['approved','reimbursed'])->sum('amount'),
        ];

        return view('livewire.expenses.expense-index', [
            'claims' => $claims,
            'stats'  => $stats,
        ])->layout('layouts.app', ['title' => 'Expense Claims']);
    }
}