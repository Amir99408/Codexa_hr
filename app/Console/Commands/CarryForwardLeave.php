<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveCarryForward;
use App\Models\LeaveType;
use Illuminate\Console\Command;

class CarryForwardLeave extends Command
{
    protected $signature   = 'leave:carry-forward {year? : The year to carry forward FROM (default: previous year)}';
    protected $description = 'Calculate unused leave balances and carry them forward to the next year';

    public function handle(): int
    {
        $fromYear = (int) ($this->argument('year') ?? (now()->year - 1));
        $toYear   = $fromYear + 1;

        $this->info("Carrying forward unused leave from {$fromYear} → {$toYear}");

        $leaveTypes = LeaveType::where('carry_forward', true)->get();

        if ($leaveTypes->isEmpty()) {
            $this->warn('No leave types have carry-forward enabled.');
            return self::SUCCESS;
        }

        $employees = Employee::where('status', 'active')->get();
        $count     = 0;

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $leaveType) {
                $used = Leave::where('employee_id', $employee->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->whereIn('status', ['approved'])
                    ->whereYear('from_date', $fromYear)
                    ->sum('days');

                // Include any days carried forward into fromYear
                $previousCarry = LeaveCarryForward::where('employee_id', $employee->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->where('year', $fromYear)
                    ->value('days') ?? 0;

                $totalAllowed = $leaveType->days_allowed + $previousCarry;
                $unused       = max(0, $totalAllowed - $used);

                if ($unused > 0) {
                    LeaveCarryForward::updateOrCreate(
                        [
                            'employee_id'   => $employee->id,
                            'leave_type_id' => $leaveType->id,
                            'year'          => $toYear,
                        ],
                        ['days' => $unused]
                    );

                    $this->line("  {$employee->full_name} — {$leaveType->name}: {$unused} day(s) carried to {$toYear}");
                    $count++;
                }
            }
        }

        $this->info("Done. {$count} carry-forward record(s) created.");
        return self::SUCCESS;
    }
}
