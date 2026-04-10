<?php

namespace App\Livewire\Portal;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use Livewire\Component;

class EmployeeDashboard extends Component
{
    public function render()
    {
        $employee = auth()->user()->employee;

        if (!$employee) {
            return view('livewire.portal.employee-dashboard', [
                'employee'     => null,
                'todayAtt'     => null,
                'leaveBalance' => [],
                'recentLeaves' => collect(),
                'latestPayroll'=> null,
            ])->layout('layouts.portal', ['title' => 'My Dashboard']);
        }

        $todayAtt = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        $approvedLeaves = Leave::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->whereYear('from_date', now()->year)
            ->get();

        $recentLeaves = Leave::where('employee_id', $employee->id)
            ->with('leaveType')
            ->latest()
            ->take(5)
            ->get();

        $latestPayroll = Payroll::where('employee_id', $employee->id)
            ->where('status', 'paid')
            ->latest()
            ->first();

        return view('livewire.portal.employee-dashboard', [
            'employee'      => $employee,
            'todayAtt'      => $todayAtt,
            'approvedLeaves'=> $approvedLeaves,
            'recentLeaves'  => $recentLeaves,
            'latestPayroll' => $latestPayroll,
        ])->layout('layouts.portal', ['title' => 'My Dashboard']);
    }
}
