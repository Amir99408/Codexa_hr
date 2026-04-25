<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $records = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get(['id', 'date', 'check_in', 'check_out', 'status', 'work_hours', 'overtime_hours']);

        return response()->json($records);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'date'     => 'required|date',
            'check_in' => 'required|date_format:H:i',
        ]);

        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $existing = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $request->date)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already checked in for this date.'], 422);
        }

        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'date'        => $request->date,
            'check_in'    => $request->check_in,
            'status'      => 'present',
        ]);

        return response()->json($attendance, 201);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'date'      => 'required|date',
            'check_out' => 'required|date_format:H:i',
        ]);

        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $request->date)
            ->firstOrFail();

        $checkIn  = \Carbon\Carbon::parse($attendance->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $hours    = round($checkIn->floatDiffInHours($checkOut), 2);
        $overtime = max(0, round($hours - 8, 2));

        $attendance->update([
            'check_out'      => $request->check_out,
            'work_hours'     => $hours,
            'overtime_hours' => $overtime,
        ]);

        return response()->json($attendance);
    }

    public function today(Request $request)
    {
        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        return response()->json($attendance);
    }
}
