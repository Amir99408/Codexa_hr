<?php

namespace App\Livewire\WarningLetters;

use App\Models\WarningLetter;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;

class WarningLetterIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterType   = '';
    public string $message      = '';

    public function delete(int $id): void
    {
        WarningLetter::destroy($id);
        $this->message = 'Warning letter deleted.';
    }

    public function render()
    {
        $letters = WarningLetter::query()
            ->with(['employee.department', 'issuedBy'])
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->latest()
            ->paginate(15);

        $stats = [
            'total'          => WarningLetter::count(),
            'this_month'     => WarningLetter::whereMonth('issued_date', now()->month)->count(),
            'unacknowledged' => WarningLetter::where('employee_acknowledged', false)->count(),
            'final'          => WarningLetter::where('severity', 'final')->count(),
        ];

        return view('livewire.warning-letters.warning-letter-index', [
            'letters' => $letters,
            'stats'   => $stats,
        ])->layout('layouts.app', ['title' => 'Warning Letters']);
    }
}