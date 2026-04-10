<?php

namespace App\Livewire\AuditLog;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;

class AuditLogIndex extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $filterAction = '';
    public string $filterModel  = '';
    public string $dateFrom    = '';
    public string $dateTo      = '';
    public string $message = '';

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingFilterAction(): void { $this->resetPage(); }
    public function updatingFilterModel(): void  { $this->resetPage(); }

    public function clearFilters(): void
    {
        $this->search       = '';
        $this->filterAction = '';
        $this->filterModel  = '';
        $this->dateFrom     = '';
        $this->dateTo       = '';
        $this->resetPage();
    }

    public function render()
    {
        $logs = AuditLog::query()
            ->with('user')
            ->when($this->search, fn($q) =>
                $q->where('description', 'like', "%{$this->search}%")
            )
            ->when($this->filterAction, fn($q) =>
                $q->where('action', $this->filterAction)
            )
            ->when($this->filterModel, fn($q) =>
                $q->where('model', $this->filterModel)
            )
            ->when($this->dateFrom, fn($q) =>
                $q->whereDate('created_at', '>=', $this->dateFrom)
            )
            ->when($this->dateTo, fn($q) =>
                $q->whereDate('created_at', '<=', $this->dateTo)
            )
            ->latest()
            ->paginate(50);

        $actions = AuditLog::distinct()->pluck('action')->sort()->values();
        $models  = AuditLog::distinct()->pluck('model')->sort()->values();

        return view('livewire.audit-log.audit-log-index', [
            'logs'    => $logs,
            'actions' => $actions,
            'models'  => $models,
        ])->layout('layouts.app', ['title' => 'Audit Log']);
    }
    public function clearOldLogs(): void
{
    AuditLog::where('created_at', '<', now()->subDays(90))->delete();
    $this->message = 'Logs older than 90 days cleared.';
}
}
