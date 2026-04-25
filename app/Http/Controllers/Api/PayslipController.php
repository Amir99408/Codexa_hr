<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $payslips = Payroll::where('employee_id', $employee->id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->limit(12)
            ->get(['id', 'month', 'year', 'basic_salary', 'total_earnings', 'total_deductions', 'net_salary', 'status']);

        return response()->json($payslips);
    }

    public function show(Request $request, int $id)
    {
        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $payroll = Payroll::where('employee_id', $employee->id)
            ->findOrFail($id);

        return response()->json($payroll);
    }
}
