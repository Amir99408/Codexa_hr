<?php

namespace App\Livewire\Recruitment;

use App\Models\Job;
use App\Models\Applicant;
use App\Models\Employee;
use App\Models\Department;
use App\Services\AuditService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicantIndex extends Component
{
    use WithFileUploads;

    public Job $job;
    public string $activeStage = 'all';
    public string $message     = '';

    // Add applicant form
    public bool   $showAddModal     = false;
    public string $name             = '';
    public string $email            = '';
    public string $phone            = '';
    public        $cv               = null;
    public string $notes            = '';

    // Interview scheduler
    public bool   $showInterviewModal = false;
    public ?int   $interviewApplicantId = null;
    public string $interview_date    = '';
    public string $interview_time    = '';
    public ?int   $interviewer_id    = null;

    // Convert to employee
    public bool   $showConvertModal  = false;
    public ?int   $convertApplicantId = null;

    public function mount(Job $job): void
    {
        $this->job = $job;
    }

    public function moveStage(int $applicantId, string $stage): void
    {
        Applicant::findOrFail($applicantId)->update(['stage' => $stage]);
        $this->message = 'Applicant moved to ' . ucfirst($stage);
    }

    public function saveApplicant(): void
    {
        $this->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'cv'    => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'notes' => 'nullable|string',
        ]);

        $cvPath = null;
        if ($this->cv) {
            $cvPath = $this->cv->store('cvs', 'local');
        }

        Applicant::create([
            'job_posting_id' => $this->job->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'phone'  => $this->phone,
            'cv_path'=> $cvPath,
            'notes'  => $this->notes,
            'stage'  => 'applied',
        ]);

        $this->reset(['name', 'email', 'phone', 'cv', 'notes', 'showAddModal']);
        $this->message = 'Applicant added successfully!';
    }

    public function openInterview(int $id): void
    {
        $this->interviewApplicantId = $id;
        $this->showInterviewModal   = true;
        $this->interview_date       = now()->addDays(3)->format('Y-m-d');
        $this->interview_time       = '10:00';
    }

    public function saveInterview(): void
    {
        $this->validate([
            'interview_date' => 'required|date',
            'interview_time' => 'required|string',
            'interviewer_id' => 'nullable|exists:employees,id',
        ]);

        Applicant::findOrFail($this->interviewApplicantId)->update([
            'interview_date' => $this->interview_date,
            'interview_time' => $this->interview_time,
            'interviewer_id' => $this->interviewer_id,
            'stage'          => 'interview',
        ]);

        $this->reset(['showInterviewModal', 'interviewApplicantId', 'interview_date', 'interview_time', 'interviewer_id']);
        $this->message = 'Interview scheduled!';
    }

    public function confirmConvert(int $id): void
    {
        $this->convertApplicantId = $id;
        $this->showConvertModal   = true;
    }

    public function convertToEmployee(): void
    {
        $applicant = Applicant::findOrFail($this->convertApplicantId);

        $lastEmp = Employee::latest('id')->first();
$next    = $lastEmp ? (intval(substr($lastEmp->emp_code, 4)) + 1) : 1;
$empCode = 'EMP-' . str_pad($next, 4, '0', STR_PAD_LEFT);

        $employee = Employee::create([
            'emp_code'   => $empCode,
            'first_name' => explode(' ', $applicant->name)[0],
            'last_name'  => implode(' ', array_slice(explode(' ', $applicant->name), 1)) ?: '-',
            'phone'      => $applicant->phone,
            'join_date'  => today()->format('Y-m-d'),
            'basic_salary' => 0,
            'status'     => 'active',
            'department_id' => $this->job->department_id,
            'designation'   => $this->job->title,
        ]);

        $applicant->update(['stage' => 'hired']);

        AuditService::log(
            action: 'created',
            model: 'Employee',
            description: "Converted applicant {$applicant->name} to employee ({$empCode})",
            modelId: $employee->id,
        );

        $this->reset(['showConvertModal', 'convertApplicantId']);
        $this->message = "{$applicant->name} converted to employee successfully!";
    }

    public function render()
    {
        $applicants = Applicant::where('job_posting_id', $this->job->id)
    ->when($this->activeStage !== 'all', fn($q) => $q->where('stage', $this->activeStage))
    ->with('interviewer')
    ->latest()
    ->get();

$stageCounts = Applicant::where('job_posting_id', $this->job->id)
    ->selectRaw('stage, count(*) as count')
    ->groupBy('stage')
    ->pluck('count', 'stage');

        $employees = Employee::where('status', 'active')->get();

        return view('livewire.recruitment.applicant-index', [
            'applicants'  => $applicants,
            'stageCounts' => $stageCounts,
            'employees'   => $employees,
        ])->layout('layouts.app', ['title' => 'Applicants — ' . $this->job->title]);
    }
}
