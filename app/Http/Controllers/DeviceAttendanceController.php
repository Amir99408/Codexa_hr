<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceDeviceLog;
use App\Models\Employee;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeviceAttendanceController extends Controller
{
    public function receive(Request $request)
    {
        // Check if device sync is enabled
        if (!Setting::get('device_enabled')) {
            return response()->json(['error' => 'Device sync disabled'], 403);
        }

        // Validate secret key
        $secret = $request->header('X-Device-Secret') ?? $request->input('secret');
        if ($secret !== Setting::get('device_secret')) {
            return response()->json(['error' => 'Invalid secret key'], 401);
        }

        // Support both single punch and batch
        $punches = $request->input('punches') ?? [$request->all()];

        $results = [];
        foreach ($punches as $punch) {
            $results[] = $this->processPunch($punch, $request->input('device_serial'));
        }

        return response()->json(['success' => true, 'processed' => count($results), 'results' => $results]);
    }

    // ZKTeco ADMS format receiver
    public function zkteco(Request $request)
    {
        if (!Setting::get('device_enabled')) {
            return response('OK', 200);
        }

        $serial = $request->input('SN');
        $table  = $request->input('table');

        if ($table !== 'ATTLOG') {
            return response("OK\n", 200);
        }

        $attLog = $request->input('AttLog', '');
        $lines  = array_filter(explode("\n", trim($attLog)));

        foreach ($lines as $line) {
            $parts = preg_split('/\t/', trim($line));
            if (count($parts) < 2) continue;

            $empCode   = trim($parts[0]);
            $punchTime = trim($parts[1]);
            $status    = trim($parts[2] ?? '0');

            $this->processPunch([
                'employee_code' => $empCode,
                'punch_time'    => $punchTime,
                'punch_type'    => $status === '1' ? 'out' : 'in',
            ], $serial);
        }

        return response("OK\n", 200);
    }

    private function processPunch(array $data, ?string $deviceSerial): array
    {
        $empCode   = trim($data['employee_code'] ?? $data['pin'] ?? '');
        $punchTime = $data['punch_time'] ?? $data['datetime'] ?? now()->toDateTimeString();
        $punchType = $data['punch_type'] ?? 'unknown';

        try {
            $punchTime = Carbon::parse($punchTime);
        } catch (\Exception) {
            return ['status' => 'error', 'message' => 'Invalid punch time'];
        }

        // Find employee by device_id first, then fall back to emp_code
        $employee = Employee::where('device_id', $empCode)->first()
                 ?? Employee::where('emp_code', $empCode)->first();

        // Check for duplicate (same employee, same minute)
        $duplicate = AttendanceDeviceLog::where('employee_code', $empCode)
            ->whereBetween('punch_time', [
                $punchTime->copy()->subMinute(),
                $punchTime->copy()->addMinute(),
            ])
            ->exists();

        $logStatus = $duplicate ? 'duplicate' : ($employee ? 'matched' : 'unmatched');

        // Save log
        AttendanceDeviceLog::create([
            'employee_id'   => $employee?->id,
            'employee_code' => $empCode,
            'punch_time'    => $punchTime,
            'punch_type'    => in_array($punchType, ['in', 'out']) ? $punchType : 'unknown',
            'device_serial' => $deviceSerial,
            'status'        => $logStatus,
            'raw_data'      => $data,
        ]);

        // Create/update attendance record if matched and not duplicate
        if ($employee && !$duplicate) {
            $date = $punchTime->toDateString();

            $attendance = Attendance::firstOrCreate(
                ['employee_id' => $employee->id, 'date' => $date],
                [
                    'status'     => 'present',
                    'check_in'   => $punchTime->toTimeString(),
                    'source'     => 'device',
                ]
            );

            // Update check_out if it's an out punch and attendance already exists
            if ($punchType === 'out' && $attendance->wasRecentlyCreated === false) {
                $attendance->update(['check_out' => $punchTime->toTimeString()]);
            }
        }

        return ['status' => $logStatus, 'employee_code' => $empCode];
    }
}
