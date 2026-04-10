<?php

namespace App\Livewire\Advances;

use App\Models\Advance;
use App\Models\Employee;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;

class AdvanceIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';
    public string $message      = '';

    // Add Advance Form
    public bool   $showModal       = false;
    public ?int   $employee_id     = null;
    public string $total_amount    = '';
    public string $repayment_type  = 'installment';
    public string $installment_amount = '';
    public int    $start_month;
    public int    $start_year;
    public string $notes           = '';

    // Reject
    public bool   $showRejectModal    = false;
    public ?int   $rejectId           = null;
    public string $rejection_reason   = '';

    public function mount(): void
    {
        $this->start_month = now()->month;
        $this->start_year  = now()->year;
    }

    public function openModal(): void
    {
        $this->reset(['employee_id','total_amount','repayment_type','installment_amount','notes']);
        $this->repayment_type = 'installment';
        $this->start_month    = now()->month;
        $this->start_year     = now()->year;
        $this->showModal      = true;
    }

    public function save(): void
    {
        $rules = [
            'employee_id'    => 'required|exists:employees,id',
            'total_amount'   => 'required|numeric|min:1',
            'repayment_type' => 'required|in:full,installment',
            'start_month'    => 'required|integer|min:1|max:12',
            'start_year'     => 'required|integer',
        ];

        if ($this->repayment_type === 'installment') {
            $rules['installment_amount'] = 'required|numeric|min:1|lte:total_amount';
        }

        $this->validate($rules);

        $advance = Advance::create([
            'employee_id'        => $this->employee_id,
            'approved_by'        => auth()->id(),
            'total_amount'       => $this->total_amount,
            'installment_amount' => $this->repayment_type === 'installment' ? $this->installment_amount : null,
            'paid_amount'        => 0,
            'remaining_amount'   => $this->total_amount,
            'repayment_type'     => $this->repayment_type,
            'start_month'        => $this->start_month,
            'start_year'         => $this->start_year,
            'status'             => 'active',
            'notes'              => $this->notes,
        ]);

        NotificationService::notifyEmployee(
            employeeId: $this->employee_id,
            title: 'Advance Approved 💰',
            message: "An advance of " . currency($this->total_amount) . " has been approved for you.",
            type: 'success',
            url: '/portal/advance',
        );

        $this->showModal = false;
        $this->message   = 'Advance created successfully!';
    }

    public function approve(int $id): void
    {
        $advance = Advance::with('employee')->findOrFail($id);
        $advance->update([
            'status'      => 'active',
            'approved_by' => auth()->id(),
        ]);

        NotificationService::notifyEmployee(
            employeeId: $advance->employee_id,
            title: 'Advance Approved ✅',
            message: "Your advance request of " . currency($advance->total_amount) . " has been approved.",
            type: 'success',
            url: '/portal/advance',
        );

        $this->message = 'Advance approved!';
    }

    public function openReject(int $id): void
    {
        $this->rejectId          = $id;
        $this->rejection_reason  = '';
        $this->showRejectModal   = true;
    }

    public function reject(): void
    {
        $this->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $advance = Advance::with('employee')->findOrFail($this->rejectId);
        $advance->update([
            'status'           => 'rejected',
            'rejection_reason' => $this->rejection_reason,
        ]);

        NotificationService::notifyEmployee(
            employeeId: $advance->employee_id,
            title: 'Advance Rejected ❌',
            message: "Your advance request has been rejected.",
            type: 'danger',
            url: '/portal/advance',
        );

        $this->reset(['showRejectModal','rejectId','rejection_reason']);
        $this->message = 'Advance rejected.';
    }

    public function markCompleted(int $id): void
    {
        Advance::findOrFail($id)->update([
            'status'           => 'completed',
            'remaining_amount' => 0,
            'paid_amount'      => Advance::find($id)->total_amount,
        ]);
        $this->message = 'Advance marked as completed.';
    }

    public function render()
    {
        $advances = Advance::query()
            ->with(['employee.department', 'approvedBy'])
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        $stats = [
            'total'     => Advance::count(),
            'active'    => Advance::where('status', 'active')->count(),
            'pending'   => Advance::where('status', 'pending')->count(),
            'total_outstanding' => Advance::where('status', 'active')->sum('remaining_amount'),
        ];

        $employees = Employee::where('status', 'active')->get();

        return view('livewire.advances.advance-index', [
            'advances'  => $advances,
            'stats'     => $stats,
            'employees' => $employees,
        ])->layout('layouts.app', ['title' => 'Advance Management']);
    }
}