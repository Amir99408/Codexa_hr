<?php

namespace App\Livewire\Careers;

use App\Models\Job;
use App\Models\Applicant;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class CareerApply extends Component
{
    use WithFileUploads;

    public Job $job;

    public string $name         = '';
    public string $email        = '';
    public string $phone        = '';
    public string $cover_letter = '';
    public        $cv           = null;
    public bool   $submitted    = false;

    public function mount(Job $job): void
    {
        abort_if($job->status !== 'open', 404);
        $this->job = $job;
    }

    public function submit(): void
    {
        $this->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:150',
            'phone'        => 'nullable|string|max:20',
            'cover_letter' => 'nullable|string|max:2000',
            'cv'           => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cvPath = null;
        if ($this->cv) {
            $cvPath = $this->cv->store('cvs', 'local');
        }

        Applicant::create([
            'job_posting_id' => $this->job->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'notes'          => $this->cover_letter,
            'cv_path'        => $cvPath,
            'stage'          => 'applied',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        $companyName = Setting::get('company_name', config('app.name'));

        return view('livewire.careers.career-apply', compact('companyName'))
            ->layout('layouts.careers', ['title' => $this->job->title . ' — ' . $companyName]);
    }
}
