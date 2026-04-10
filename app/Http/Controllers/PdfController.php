<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PdfController extends Controller
{
    // Payslip PDF
    public function payslip(Payroll $payroll)
    {
        $payroll->load(['employee.department', 'items']);

        $pdf = Pdf::loadView('pdf.payslip', compact('payroll'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('payslip-'.$payroll->employee->emp_code.'-'.$payroll->month_name.'.pdf');
    }

    // Attendance Report PDF
    public function attendanceReport(Request $request)
    {
        $from_date    = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $to_date      = $request->get('to_date', now()->format('Y-m-d'));
        $filterDept   = $request->get('dept', '');
        $filterStatus = $request->get('status', '');

        $records = Attendance::query()
            ->with(['employee.department'])
            ->whereDate('date', '>=', $from_date)
            ->whereDate('date', '<=', $to_date)
            ->when($filterStatus, fn($q) => $q->where('status', $filterStatus))
            ->when($filterDept, fn($q) =>
                $q->whereHas('employee', fn($eq) =>
                    $eq->where('department_id', $filterDept)
                )
            )
            ->orderBy('date', 'desc')
            ->get();

        $summary = [
            'total'    => $records->count(),
            'present'  => $records->where('status', 'present')->count(),
            'absent'   => $records->where('status', 'absent')->count(),
            'late'     => $records->where('status', 'late')->count(),
            'half_day' => $records->where('status', 'half_day')->count(),
            'wfh'      => $records->where('status', 'work_from_home')->count(),
        ];

        $pdf = Pdf::loadView('pdf.attendance-report', compact(
            'records', 'summary', 'from_date', 'to_date'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('attendance-report-'.$from_date.'-to-'.$to_date.'.pdf');
    }

    // Leave Report PDF
    public function leaveReport(Request $request)
    {
        $from_date    = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $to_date      = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));
        $filterStatus = $request->get('status', '');

        $records = Leave::query()
            ->with(['employee.department', 'leaveType'])
            ->whereDate('from_date', '>=', $from_date)
            ->whereDate('from_date', '<=', $to_date)
            ->when($filterStatus, fn($q) => $q->where('status', $filterStatus))
            ->latest()
            ->get();

        $summary = [
            'total'    => $records->count(),
            'approved' => $records->where('status', 'approved')->count(),
            'pending'  => $records->where('status', 'pending')->count(),
            'rejected' => $records->where('status', 'rejected')->count(),
            'days'     => $records->where('status', 'approved')->sum('days'),
        ];

        $pdf = Pdf::loadView('pdf.leave-report', compact(
            'records', 'summary', 'from_date', 'to_date'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('leave-report-'.$from_date.'-to-'.$to_date.'.pdf');
    }

    // Payroll Report PDF
    public function payrollReport(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $records = Payroll::query()
            ->with(['employee.department'])
            ->where('month', $month)
            ->where('year', $year)
            ->latest()
            ->get();

        $summary = [
            'total_employees'  => $records->count(),
            'total_basic'      => $records->sum('basic_salary'),
            'total_earnings'   => $records->sum('total_earnings'),
            'total_deductions' => $records->sum('total_deductions'),
            'total_net'        => $records->sum('net_salary'),
        ];

        $monthName = Carbon::createFromDate($year, $month, 1)->format('F Y');

        $pdf = Pdf::loadView('pdf.payroll-report', compact(
            'records', 'summary', 'monthName'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('payroll-report-'.$monthName.'.pdf');
    }
}
