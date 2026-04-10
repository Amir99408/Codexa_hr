<?php

namespace App\Livewire\Recruitment;

use App\Models\Job;
use App\Models\Department;
use Livewire\Component;

class JobCreate extends Component
{
    public string  $title        = '';
    public ?int    $department_id = null;
    public string  $description  = '';
    public string  $requirements = '';
    public string  $location     = '';
    public string  $type         = 'full_time';
    public string  $salary_min   = '';
    public string  $salary_max   = '';
    public int     $positions    = 1;
    public string  $deadline     = '';
    public string  $status       = 'open';
    public ?int    $editId       = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $job = Job::findOrFail($id);
            $this->editId       = $id;
            $this->title        = $job->title;
            $this->department_id = $job->department_id;
            $this->description  = $job->description ?? '';
            $this->requirements = $job->requirements ?? '';
            $this->location     = $job->location ?? '';
            $this->type         = $job->type;
            $this->salary_min   = $job->salary_min ?? '';
            $this->salary_max   = $job->salary_max ?? '';
            $this->positions    = $job->positions;
            $this->deadline     = $job->deadline?->format('Y-m-d') ?? '';
            $this->status       = $job->status;
        }

        $this->deadline = $this->deadline ?: now()->addMonth()->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate([
            'title'         => 'required|string|max:200',
            'department_id' => 'nullable|exists:departments,id',
            'description'   => 'nullable|string',
            'requirements'  => 'nullable|string',
            'location'      => 'nullable|string|max:100',
            'type'          => 'required|in:full_time,part_time,contract,internship',
            'salary_min'    => 'nullable|numeric|min:0',
            'salary_max'    => 'nullable|numeric|min:0',
            'positions'     => 'required|integer|min:1',
            'deadline'      => 'nullable|date',
            'status'        => 'required|in:open,closed,on_hold',
        ]);

        $data = [
            'title'         => $this->title,
            'department_id' => $this->department_id,
            'description'   => $this->description,
            'requirements'  => $this->requirements,
            'location'      => $this->location,
            'type'          => $this->type,
            'salary_min'    => $this->salary_min ?: null,
            'salary_max'    => $this->salary_max ?: null,
            'positions'     => $this->positions,
            'deadline'      => $this->deadline ?: null,
            'status'        => $this->status,
        ];

        if ($this->editId) {
            Job::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Job updated successfully.');
        } else {
            Job::create($data);
            session()->flash('success', 'Job posted successfully.');
        }

        $this->redirect(route('recruitment.jobs'));
    }

    public function render()
    {
        return view('livewire.recruitment.job-create', [
            'departments' => Department::all(),
        ])->layout('layouts.app', ['title' => $this->editId ? 'Edit Job' : 'Post New Job']);
    }
}