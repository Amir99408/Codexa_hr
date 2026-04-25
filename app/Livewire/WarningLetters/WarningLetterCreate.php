<?php

namespace App\Livewire\WarningLetters;

use App\Models\WarningLetter;
use App\Models\Employee;
use App\Services\NotificationService;
use App\Services\AuditService;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\WarningLetterIssuedMail;

class WarningLetterCreate extends Component
{
    public ?int    $editId      = null;
    public ?int    $employee_id = null;
    public string  $type        = 'misconduct';
    public string  $severity    = 'minor';
    public string  $subject     = '';
    public string  $body        = '';
    public string  $issued_date = '';

    // Template subjects
    public array $templates = [
        'misconduct'  => 'Warning Letter — Misconduct',
        'performance' => 'Warning Letter — Poor Performance',
        'late'        => 'Warning Letter — Habitual Late Attendance',
        'absence'     => 'Warning Letter — Unauthorized Absence',
        'other'       => 'Warning Letter',
    ];

    public function mount(?WarningLetter $warningLetter = null): void
    {
        $this->issued_date = today()->format('Y-m-d');

        if ($warningLetter && $warningLetter->exists) {
            $this->editId      = $warningLetter->id;
            $this->employee_id = $warningLetter->employee_id;
            $this->type        = $warningLetter->type;
            $this->severity    = $warningLetter->severity;
            $this->subject     = $warningLetter->subject;
            $this->body        = $warningLetter->body;
            $this->issued_date = $warningLetter->issued_date->format('Y-m-d');
        }
    }

    public function updatedType(): void
    {
        $this->subject = $this->templates[$this->type] ?? 'Warning Letter';
        $this->body    = $this->generateTemplate();
    }

    public function updatedEmployeeId(): void
    {
        if (!$this->body) {
            $this->body = $this->generateTemplate();
        }
    }
    public function reloadTemplate(): void
{
    $this->subject = $this->templates[$this->type] ?? 'Warning Letter';
    $this->body    = $this->generateTemplate();
}

    private function generateTemplate(): string
    {
        $employee = $this->employee_id
            ? Employee::find($this->employee_id)
            : null;

        $name     = $employee ? $employee->full_name : '[Employee Name]';
        $company  = \App\Models\Setting::get('company_name', 'Company');
        $date     = now()->format('d F Y');

        return match($this->type) {
            'misconduct' => "Date: {$date}

To,
{$name}

Subject: Warning Letter — Misconduct

Dear {$name},

This letter is to formally inform you that your conduct on [Date of Incident] was found to be in violation of company policies. Specifically, [describe the misconduct briefly].

Such behavior is unacceptable and against the code of conduct of {$company}. This letter serves as a formal warning.

You are required to immediately improve your conduct. Any recurrence of such behavior may lead to further disciplinary action, including termination of employment.

Please acknowledge receipt of this letter by signing below.

Regards,
HR Department
{$company}",

            'performance' => "Date: {$date}

To,
{$name}

Subject: Warning Letter — Performance Improvement Required

Dear {$name},

This letter is to formally notify you that your performance over the past [period] has been below the expected standards. Specifically, the following areas require immediate improvement:

1. [Area of concern]
2. [Area of concern]

You are expected to show measurable improvement within [timeframe]. A performance review will be conducted on [date].

Failure to meet the required performance standards may result in further disciplinary action.

Regards,
HR Department
{$company}",

            'late' => "Date: {$date}

To,
{$name}

Subject: Warning Letter — Habitual Late Attendance

Dear {$name},

Our attendance records indicate that you have been consistently late to work on multiple occasions over the past [period]. This is unacceptable and affects team productivity.

You are hereby warned to report on time as per your shift schedule. Any further instances of late attendance will result in salary deduction and/or further disciplinary action.

Regards,
HR Department
{$company}",

            'absence' => "Date: {$date}

To,
{$name}

Subject: Warning Letter — Unauthorized Absence

Dear {$name},

It has been noted that you were absent from work on [dates] without prior approval or valid reason. Unauthorized absence is a serious violation of company policy.

You are required to explain your absence in writing within [X] working days. Failure to do so may result in further disciplinary action.

Regards,
HR Department
{$company}",

            default => "Date: {$date}

To,
{$name}

Subject: Warning Letter

Dear {$name},

This letter serves as a formal warning regarding [describe the issue].

You are expected to [required action]. Please ensure this does not recur.

Regards,
HR Department
{$company}",
        };
    }

    public function save(): void
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'type'        => 'required|in:misconduct,performance,late,absence,other',
            'severity'    => 'required|in:minor,major,final',
            'subject'     => 'required|string|max:200',
            'body'        => 'required|string',
            'issued_date' => 'required|date',
        ]);

        if ($this->editId) {
            $letter = WarningLetter::findOrFail($this->editId);
            $letter->update([
                'employee_id' => $this->employee_id,
                'type'        => $this->type,
                'severity'    => $this->severity,
                'subject'     => $this->subject,
                'body'        => $this->body,
                'issued_date' => $this->issued_date,
            ]);
        } else {
            $letter = WarningLetter::create([
                'employee_id' => $this->employee_id,
                'issued_by'   => auth()->id(),
                'type'        => $this->type,
                'severity'    => $this->severity,
                'subject'     => $this->subject,
                'body'        => $this->body,
                'issued_date' => $this->issued_date,
            ]);

            NotificationService::notifyEmployee(
                employeeId: $this->employee_id,
                title: '⚠️ Warning Letter Issued',
                message: "A warning letter has been issued to you: {$this->subject}",
                type: 'warning',
                url: '/portal/warnings',
            );

            AuditService::log(
                action: 'created',
                model: 'WarningLetter',
                description: "Issued warning letter to employee ID {$this->employee_id}: {$this->subject}",
                modelId: $letter->id,
            );

            $employee = Employee::with('user')->find($this->employee_id);
            if ($employee?->user?->email) {
                Mail::to($employee->user->email)->queue(new WarningLetterIssuedMail($letter));
            }
        }

        session()->flash('success', 'Warning letter saved successfully.');
        $this->redirect(route('warnings.index'));
    }

    public function render()
    {
        return view('livewire.warning-letters.warning-letter-create', [
            'employees' => Employee::where('status', 'active')->get(),
        ])->layout('layouts.app', ['title' => $this->editId ? 'Edit Warning Letter' : 'Issue Warning Letter']);
    }
}