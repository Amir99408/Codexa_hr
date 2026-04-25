<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Exports\AttendanceExport;
use App\Exports\PayrollExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function employees(Request $request)
    {
        $filename = 'employees_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new EmployeesExport(
                search: $request->get('search', ''),
                dept:   $request->get('dept',   ''),
                status: $request->get('status', ''),
            ),
            $filename
        );
    }

    public function attendance(Request $request)
    {
        $filename = 'attendance_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new AttendanceExport(
                date:   $request->get('date',   ''),
                dept:   $request->get('dept',   ''),
                status: $request->get('status', ''),
            ),
            $filename
        );
    }

    public function payroll(Request $request)
    {
        $month    = (int) $request->get('month', now()->month);
        $year     = (int) $request->get('year',  now()->year);
        $filename = 'payroll_' . \Carbon\Carbon::createFromDate($year, $month, 1)->format('Y_F') . '.xlsx';

        return Excel::download(
            new PayrollExport(
                month:  $month,
                year:   $year,
                dept:   $request->get('dept',   ''),
                status: $request->get('status', ''),
            ),
            $filename
        );
    }
}
