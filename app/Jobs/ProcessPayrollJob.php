<?php

namespace App\Jobs;

use App\Models\Advance;
use App\Models\Employee;
use App\Services\AuditService;
use App\Services\PayrollCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessPayrollJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;

    public function __construct(
        private int $employeeId,
        private int $month,
        private int $year,
    ) {}

    public function handle(PayrollCalculatorService $service): void
    {
        $employee = Employee::findOrFail($this->employeeId);

        DB::transaction(function () use ($employee, $service) {
            $payroll = $service->calculate($employee, $this->month, $this->year);

            if ($payroll->advance_id && $payroll->advance_deduction > 0) {
                $advance = Advance::find($payroll->advance_id);
                if ($advance && $advance->status === 'active') {
                    $advance->paid_amount      = round((float) $advance->paid_amount + (float) $payroll->advance_deduction, 2);
                    $advance->remaining_amount = round((float) $advance->remaining_amount - (float) $payroll->advance_deduction, 2);

                    if ($advance->remaining_amount <= 0) {
                        $advance->remaining_amount = 0;
                        $advance->status           = 'completed';
                    }
                    $advance->save();
                }
            }

            AuditService::log(
                action: 'created',
                model: 'Payroll',
                description: "Ran payroll for {$employee->full_name} — Net: {$payroll->net_salary}",
                modelId: $payroll->id,
            );
        });
    }
}
