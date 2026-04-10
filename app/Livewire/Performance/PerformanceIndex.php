<?php

namespace App\Livewire\Performance;

use App\Models\PerformanceReview;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class PerformanceIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterYear   = '';
    public string $filterStatus = '';
    public string $message      = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function delete(int $id): void
    {
        PerformanceReview::destroy($id);
        $this->message = 'Review deleted.';
    }

    public function render()
    {
        $reviews = PerformanceReview::query()
            ->with(['employee.department', 'reviewer', 'criteria'])
            ->when($this->search, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterYear,   fn($q) => $q->where('year', $this->filterYear))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        $years = PerformanceReview::distinct()->pluck('year')->sortDesc()->values();

        $stats = [
            'total'     => PerformanceReview::count(),
            'submitted' => PerformanceReview::where('status', 'submitted')->count(),
            'draft'     => PerformanceReview::where('status', 'draft')->count(),
            'avg_score' => round(PerformanceReview::whereNotNull('overall_score')->avg('overall_score'), 2),
        ];

        return view('livewire.performance.performance-index', [
            'reviews' => $reviews,
            'years'   => $years,
            'stats'   => $stats,
        ])->layout('layouts.app', ['title' => 'Performance Reviews']);
    }
}