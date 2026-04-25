<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Services\AuditService;
use Illuminate\Console\Command;

class CheckProbation extends Command
{
    protected $signature   = 'hr:check-probation';
    protected $description = 'Move employees from onboarding → probation once all tasks are complete, and flag overdue probations';

    public function handle(): void
    {
        // Onboarding → Probation: all tasks done
        $onboarding = Employee::where('onboarding_status', 'onboarding')
            ->with('onboardingTasks')
            ->get();

        foreach ($onboarding as $employee) {
            $tasks = $employee->onboardingTasks;
            if ($tasks->count() > 0 && $tasks->every(fn($t) => $t->is_complete)) {
                $employee->update(['onboarding_status' => 'probation']);
                AuditService::log(
                    action: 'updated',
                    model: 'Employee',
                    description: "Employee {$employee->full_name} moved to probation (all onboarding tasks complete)",
                    modelId: $employee->id,
                );
                $this->line("  → {$employee->full_name} moved to probation.");
            }
        }

        // Flag probation overdue (probation_end_date past, still on probation)
        $overdue = Employee::where('onboarding_status', 'probation')
            ->whereNotNull('probation_end_date')
            ->whereDate('probation_end_date', '<', today())
            ->get();

        foreach ($overdue as $employee) {
            $this->warn("  ! {$employee->full_name} — probation ended {$employee->probation_end_date->format('d M Y')} (needs confirmation or extension)");
        }

        $this->info("Probation check done. Moved: {$onboarding->count()} checked, {$overdue->count()} overdue.");
    }
}
