<?php

namespace App\Livewire\Portal;

use App\Models\ExpenseClaim;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;

class EmployeeExpenses extends Component
{
    use WithFileUploads;

    public string $tab          = 'list';
    public string $title        = '';
    public string $category     = 'travel';
    public string $amount       = '';
    public string $expense_date = '';
    public string $description  = '';
    public        $receipt      = null;
    public string $message      = '';

    public function mount(): void
    {
        $this->expense_date = today()->format('Y-m-d');
    }

    public function save(): void
    {
        Gate::authorize('create', ExpenseClaim::class);

        $this->validate([
            'title'        => 'required|string|max:200',
            'category'     => 'required|string',
            'amount'       => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'description'  => 'nullable|string',
            'receipt'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $employee = auth()->user()->employee;
        abort_unless($employee, 403);

        $receiptPath = null;
        if ($this->receipt) {
            $receiptPath = $this->receipt->store('receipts', 'local');
        }

        ExpenseClaim::create([
            'employee_id'  => $employee->id,
            'title'        => $this->title,
            'category'     => $this->category,
            'amount'       => $this->amount,
            'expense_date' => $this->expense_date,
            'description'  => $this->description,
            'receipt_path' => $receiptPath,
            'status'       => 'pending',
        ]);

        NotificationService::notifyAdmins(
            title: 'New Expense Claim 📋',
            message: "{$employee->full_name} submitted an expense claim of " . currency($this->amount),
            type: 'info',
            url: '/expenses',
        );

        $this->reset(['title', 'category', 'amount', 'description', 'receipt']);
        $this->expense_date = today()->format('Y-m-d');
        $this->category     = 'travel';
        $this->message      = 'Expense claim submitted successfully!';
        $this->tab          = 'list';
    }

    public function render()
    {
        $employee = auth()->user()->employee;

        $claims = ExpenseClaim::where('employee_id', $employee?->id)
            ->latest()
            ->get();

        $stats = [
            'pending'    => $claims->where('status', 'pending')->count(),
            'approved'   => $claims->where('status', 'approved')->count(),
            'reimbursed' => $claims->where('status', 'reimbursed')->count(),
            'total'      => $claims->whereIn('status', ['approved','reimbursed'])->sum('amount'),
        ];

        return view('livewire.portal.employee-expenses', [
            'claims' => $claims,
            'stats'  => $stats,
        ])->layout('layouts.portal', ['title' => 'My Expenses']);
    }
}
