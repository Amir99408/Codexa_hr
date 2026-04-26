<?php

namespace App\Livewire\Careers;

use App\Models\Job;
use App\Models\Setting;
use Livewire\Component;

class CareersIndex extends Component
{
    public string $search       = '';
    public string $filterType   = '';
    public string $filterDept   = '';

    public function render()
    {
        $jobs = Job::query()
            ->with('department')
            ->withCount('applicants')
            ->where('status', 'open')
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('location', 'like', "%{$this->search}%")
            )
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->when($this->filterDept, fn($q) => $q->where('department_id', $this->filterDept))
            ->latest()
            ->get();

        $departments = \App\Models\Department::orderBy('name')->get();
        $companyName = Setting::get('company_name', config('app.name'));

        return view('livewire.careers.careers-index', compact('jobs', 'departments', 'companyName'))
            ->layout('layouts.careers', ['title' => 'Careers — ' . $companyName]);
    }
}
