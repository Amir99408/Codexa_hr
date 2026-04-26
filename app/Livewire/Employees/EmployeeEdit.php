<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use App\Services\AuditService;
use Livewire\WithFileUploads;

class EmployeeEdit extends Component
{
    use WithFileUploads;
    public Employee $employee;

    public string  $first_name    = '';
    public string  $last_name     = '';
    public string  $phone         = '';
    public string  $designation   = '';
    public string  $gender        = '';
    public ?string $date_of_birth = null;
    public ?string $join_date     = null;
    public        $basic_salary   = '';
    public string  $address       = '';
    public string  $status        = 'active';
    public ?int    $department_id = null;
    public        $photo          = null;
    public string $device_id      = '';

    // Portal access
    public bool   $create_account    = false;
    public string $account_email     = '';
    public string $account_password  = '';

    public function mount(Employee $employee): void
    {
        $this->employee      = $employee;
        $this->first_name    = $employee->first_name;
        $this->last_name     = $employee->last_name;
        $this->phone         = $employee->phone ?? '';
        $this->designation   = $employee->designation ?? '';
        $this->gender        = $employee->gender ?? '';
        $this->date_of_birth = $employee->date_of_birth?->format('Y-m-d');
        $this->join_date     = $employee->join_date?->format('Y-m-d');
        $this->basic_salary  = $employee->basic_salary;
        $this->address       = $employee->address ?? '';
        $this->status        = $employee->status;
        $this->department_id = $employee->department_id;
        $this->device_id     = $employee->device_id ?? '';
        $this->account_email = $employee->user?->email ?? '';
    }

    protected function rules(): array
    {
        $rules = [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'phone'         => 'nullable|string|max:20',
            'designation'   => 'nullable|string|max:100',
            'gender'        => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'join_date'     => 'required|date',
            'basic_salary'  => 'required|numeric|min:0',
            'address'       => 'nullable|string',
            'status'        => 'required|in:active,inactive,terminated',
            'department_id' => 'nullable|exists:departments,id',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'device_id'     => 'nullable|string|max:50|unique:employees,device_id,' . $this->employee->id,
        ];

        if ($this->employee->user_id) {
            // Existing account: email must be unique ignoring this user
            $rules['account_email']    = 'required|email|unique:users,email,' . $this->employee->user_id;
            $rules['account_password'] = 'nullable|string|min:8';
        } elseif ($this->create_account) {
            // Creating new account
            $rules['account_email']    = 'required|email|unique:users,email';
            $rules['account_password'] = 'required|string|min:8';
        }

        return $rules;
    }

    public function removePhoto(): void
    {
        if ($this->employee->photo && \Storage::disk('public')->exists($this->employee->photo)) {
            \Storage::disk('public')->delete($this->employee->photo);
        }
        $this->employee->update(['photo' => null]);
        $this->photo = null;
    }

    public function update(): void
    {
        $this->validate();

        $old = $this->employee->only([
            'first_name','last_name','designation','basic_salary','status','department_id'
        ]);

        // Handle photo upload
        if ($this->photo) {
            if ($this->employee->photo && \Storage::disk('public')->exists($this->employee->photo)) {
                \Storage::disk('public')->delete($this->employee->photo);
            }
            $photoPath = $this->photo->store('photos/employees', 'public');
            $this->employee->update(['photo' => $photoPath]);
        }

        $this->employee->update([
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'phone'         => $this->phone,
            'designation'   => $this->designation,
            'gender'        => $this->gender,
            'date_of_birth' => $this->date_of_birth ?: null,
            'join_date'     => $this->join_date,
            'basic_salary'  => $this->basic_salary,
            'address'       => $this->address,
            'status'        => $this->status,
            'department_id' => $this->department_id,
            'device_id'     => $this->device_id ?: null,
        ]);

        // Portal access: update existing user
        if ($this->employee->user_id && $this->employee->user) {
            $userUpdate = [
                'name'  => $this->first_name . ' ' . $this->last_name,
                'email' => $this->account_email,
            ];
            if ($this->account_password) {
                $userUpdate['password'] = bcrypt($this->account_password);
            }
            $this->employee->user->update($userUpdate);
        }

        // Portal access: create new user account
        if (!$this->employee->user_id && $this->create_account) {
            $user = User::create([
                'name'     => $this->first_name . ' ' . $this->last_name,
                'email'    => $this->account_email,
                'password' => bcrypt($this->account_password),
                'photo'    => $this->employee->photo,
            ]);
            $user->assignRole('employee');
            $this->employee->update(['user_id' => $user->id]);
        }

        AuditService::log(
            action: 'updated',
            model: 'Employee',
            description: "Updated employee {$this->employee->full_name} ({$this->employee->emp_code})",
            modelId: $this->employee->id,
            oldValues: $old,
            newValues: $this->employee->fresh()->only([
                'first_name','last_name','designation','basic_salary','status','department_id'
            ]),
        );

        session()->flash('success', 'Employee updated successfully.');
        $this->redirect(route('employees.index'));
    }

    public function render()
    {
        return view('livewire.employees.employee-edit', [
            'departments' => Department::all(),
        ])->layout('layouts.app', ['title' => 'Edit Employee']);
    }
}
