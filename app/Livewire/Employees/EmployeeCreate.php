<?php

namespace App\Livewire\Employees;

use App\Models\Applicant;
use App\Models\Employee;
use App\Models\Department;
use App\Models\OnboardingTask;
use App\Models\User;
use Livewire\Component;
use App\Services\AuditService;
use Livewire\WithFileUploads;

class EmployeeCreate extends Component
{
    use WithFileUploads;

    public string  $emp_code         = '';
    public string  $device_id        = '';
    public bool    $create_account   = false;
    public string  $account_email    = '';
    public string  $account_password = '';
    public string  $first_name       = '';
    public string  $last_name        = '';
    public string  $phone            = '';
    public string  $designation      = '';
    public string  $gender           = '';
    public ?string $date_of_birth    = null;
    public ?string $join_date        = null;
    public         $basic_salary     = '';
    public string  $address          = '';
    public string  $status           = 'active';
    public ?int    $department_id    = null;
    public         $photo            = null;
    public ?int    $applicant_id     = null;

    public function mount(): void
    {
        $this->emp_code  = $this->generateEmpCode();
        $this->join_date = today()->format('Y-m-d');

        // Pre-fill from applicant if converting from recruitment
        if ($applicantId = request()->query('applicant_id')) {
            $applicant = Applicant::with('job')->find($applicantId);
            if ($applicant) {
                $this->applicant_id  = $applicant->id;
                $nameParts           = explode(' ', trim($applicant->name), 2);
                $this->first_name    = $nameParts[0];
                $this->last_name     = $nameParts[1] ?? '';
                $this->phone         = $applicant->phone ?? '';
                $this->account_email = $applicant->email ?? '';
                if ($applicant->job) {
                    $this->designation   = $applicant->job->title ?? '';
                    $this->department_id = $applicant->job->department_id;
                }
            }
        }
    }

    private function generateEmpCode(): string
    {
        $last = Employee::latest('id')->first();
        $next = $last ? $last->id + 1 : 1;
        return 'EMP-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function save(): void
    {
        $rules = [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'designation'   => 'nullable|string|max:100',
            'phone'         => 'nullable|string|max:20',
            'gender'        => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'join_date'     => 'required|date',
            'basic_salary'  => 'required|numeric|min:0',
            'status'        => 'required|in:active,inactive,terminated',
            'address'       => 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'device_id'     => 'nullable|string|max:50|unique:employees,device_id',
        ];

        if ($this->create_account) {
            $rules['account_email']    = 'required|email|unique:users,email';
            $rules['account_password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        // Handle photo upload
        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('photos/employees', 'public');
        }

        $userId = null;
        if ($this->create_account) {
            $user = User::create([
                'name'     => $this->first_name . ' ' . $this->last_name,
                'email'    => $this->account_email,
                'password' => bcrypt($this->account_password),
                'photo'    => $photoPath,
            ]);
            $user->assignRole('employee');
            $userId = $user->id;
        }

        $employee = Employee::create([
            'user_id'       => $userId,
            'emp_code'      => $this->emp_code,
            'device_id'     => $this->device_id ?: null,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'department_id' => $this->department_id,
            'designation'   => $this->designation,
            'phone'         => $this->phone,
            'gender'        => $this->gender,
            'date_of_birth' => $this->date_of_birth ?: null,
            'join_date'     => $this->join_date,
            'basic_salary'  => $this->basic_salary,
            'status'        => $this->status,
            'address'       => $this->address,
            'photo'         => $photoPath,
        ]);

        // If converting from a job applicant, mark as hired and create onboarding tasks
        if ($this->applicant_id) {
            $applicant = Applicant::find($this->applicant_id);
            if ($applicant) {
                $applicant->update(['stage' => 'hired']);

                $defaultTasks = [
                    'Complete personal information form',
                    'Submit ID and address proof documents',
                    'Sign employment contract',
                    'Complete IT setup and equipment handover',
                    'Attend company orientation session',
                    'Meet department team and manager',
                    'Complete mandatory compliance training',
                    'Set up payroll bank account details',
                ];

                foreach ($defaultTasks as $i => $task) {
                    OnboardingTask::create([
                        'employee_id' => $employee->id,
                        'task'        => $task,
                        'sort_order'  => $i + 1,
                    ]);
                }

                $employee->update([
                    'onboarding_status' => 'onboarding',
                    'probation_end_date'=> today()->addMonths(3)->format('Y-m-d'),
                ]);
            }
        }

        AuditService::log(
            action: 'created',
            model: 'Employee',
            description: "Created employee {$this->first_name} {$this->last_name} ({$this->emp_code})",
            modelId: $employee->id,
        );

        session()->flash('success', 'Employee created successfully.');
        $this->redirect(route('employees.index'));
    }

    public function render()
    {
        return view('livewire.employees.employee-create', [
            'departments' => Department::all(),
        ])->layout('layouts.app', ['title' => 'Add Employee']);
    }
}