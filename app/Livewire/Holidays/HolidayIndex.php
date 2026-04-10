<?php

namespace App\Livewire\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use Livewire\WithPagination;

class HolidayIndex extends Component
{
    use WithPagination;

    public string  $search      = '';
    public string  $filterType  = '';
    public int     $filterYear;
    public string  $message     = '';

    // Form fields
    public string  $name        = '';
    public string  $date        = '';
    public string  $type        = 'public';
    public string  $description = '';
    public bool    $is_recurring = false;
    public ?int    $editId      = null;
    public ?int    $deleteId    = null;
    public bool    $showForm    = false;

    public function mount(): void
    {
        $this->filterYear = now()->year;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $holiday             = Holiday::findOrFail($id);
        $this->editId        = $id;
        $this->name          = $holiday->name;
        $this->date          = $holiday->date->format('Y-m-d');
        $this->type          = $holiday->type;
        $this->description   = $holiday->description ?? '';
        $this->is_recurring  = $holiday->is_recurring;
        $this->showForm      = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'date' => 'required|date',
            'type' => 'required|in:public,optional,restricted',
        ]);

        if ($this->editId) {
            Holiday::findOrFail($this->editId)->update([
                'name'         => $this->name,
                'date'         => $this->date,
                'type'         => $this->type,
                'description'  => $this->description,
                'is_recurring' => $this->is_recurring,
            ]);
            $this->message = 'Holiday updated successfully.';
        } else {
            Holiday::create([
                'name'         => $this->name,
                'date'         => $this->date,
                'type'         => $this->type,
                'description'  => $this->description,
                'is_recurring' => $this->is_recurring,
            ]);
            $this->message = 'Holiday added successfully.';
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    public function delete(): void
    {
        Holiday::findOrFail($this->deleteId)->delete();
        $this->deleteId = null;
        $this->message  = 'Holiday deleted.';
    }

    private function resetForm(): void
    {
        $this->name         = '';
        $this->date         = '';
        $this->type         = 'public';
        $this->description  = '';
        $this->is_recurring = false;
        $this->editId       = null;
    }

    public function render()
    {
        $holidays = Holiday::query()
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', '%'.$this->search.'%')
            )
            ->when($this->filterType, fn($q) =>
                $q->where('type', $this->filterType)
            )
            ->whereYear('date', $this->filterYear)
            ->orderBy('date')
            ->paginate(15);

        $totalThisYear    = Holiday::whereYear('date', $this->filterYear)->count();
        $upcomingHolidays = Holiday::whereYear('date', $this->filterYear)
                                ->whereDate('date', '>=', today())
                                ->orderBy('date')
                                ->take(3)
                                ->get();

        return view('livewire.holidays.holiday-index', [
            'holidays'         => $holidays,
            'totalThisYear'    => $totalThisYear,
            'upcomingHolidays' => $upcomingHolidays,
        ])->layout('layouts.app', ['title' => 'Holidays']);
    }
}
