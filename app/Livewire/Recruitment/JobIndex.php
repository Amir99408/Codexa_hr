<?php

namespace App\Livewire\Recruitment;

use App\Models\Job;
use Livewire\Component;
use Livewire\WithPagination;

class JobIndex extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $filterStatus = '';
    public bool   $showModal   = false;
    public ?int   $deleteId    = null;
    public string $message     = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function confirmDelete(int $id): void
    {
        $this->deleteId  = $id;
        $this->showModal = true;
    }

    public function delete(): void
    {
        Job::destroy($this->deleteId);
        $this->showModal = false;
        $this->deleteId  = null;
        $this->message   = 'Job posting deleted.';
    }

    public function toggleStatus(int $id): void
    {
        $job = Job::findOrFail($id);
        $job->update([
            'status' => $job->status === 'open' ? 'closed' : 'open'
        ]);
        $this->message = 'Job status updated.';
    }

    public function render()
    {
        $jobs = Job::query()
            ->withCount('applicants')
            ->with('department')
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', "%{$this->search}%")
            )
            ->when($this->filterStatus, fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->latest()
            ->paginate(10);

        return view('livewire.recruitment.job-index', [
            'jobs' => $jobs,
        ])->layout('layouts.app', ['title' => 'Recruitment']);
    }
}