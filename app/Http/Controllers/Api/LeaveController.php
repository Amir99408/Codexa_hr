<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $leaves = Leave::where('employee_id', $employee->id)
            ->with('leaveType:id,name')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get(['id', 'leave_type_id', 'from_date', 'to_date', 'days', 'reason', 'status', 'rejection_reason', 'created_at']);

        return response()->json($leaves);
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date'     => 'required|date|after_or_equal:today',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'reason'        => 'required|string|max:500',
        ]);

        $employee = $request->user()->employee;

        if (! $employee) {
            return response()->json(['message' => 'No employee profile linked to this account.'], 403);
        }

        $from = \Carbon\Carbon::parse($request->from_date);
        $to   = \Carbon\Carbon::parse($request->to_date);
        $days = $from->diffInWeekdays($to) + 1;

        $leave = Leave::create([
            'employee_id'   => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'from_date'     => $request->from_date,
            'to_date'       => $request->to_date,
            'days'          => $days,
            'reason'        => $request->reason,
            'status'        => 'pending',
        ]);

        return response()->json($leave->load('leaveType:id,name'), 201);
    }

    public function leaveTypes()
    {
        $types = LeaveType::select('id', 'name', 'days_allowed')->get();
        return response()->json($types);
    }
}
