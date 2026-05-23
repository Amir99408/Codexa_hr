<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function ping(Request $request)
    {
        $data = $request->validate([
            'token'     => 'required|string',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy'  => 'nullable|numeric|min:0',
        ]);

        $employee = Employee::where('location_token', $data['token'])->first();

        if (! $employee) {
            return response()->json(['error' => 'Invalid token'], 403);
        }

        EmployeeLocation::create([
            'employee_id' => $employee->id,
            'latitude'    => $data['latitude'],
            'longitude'   => $data['longitude'],
            'accuracy'    => $data['accuracy'] ?? null,
            'recorded_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
