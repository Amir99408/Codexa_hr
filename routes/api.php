<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\PayslipController;

// Public
Route::post('/login', [AuthController::class, 'login']);

// Authenticated (Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/me',       [AuthController::class, 'me']);

    // Attendance
    Route::get('/attendance',          [AttendanceController::class, 'index']);
    Route::get('/attendance/today',    [AttendanceController::class, 'today']);
    Route::post('/attendance/check-in',  [AttendanceController::class, 'checkIn']);
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut']);

    // Leave
    Route::get('/leave',        [LeaveController::class, 'index']);
    Route::post('/leave',       [LeaveController::class, 'store']);
    Route::get('/leave/types',  [LeaveController::class, 'leaveTypes']);

    // Payslips
    Route::get('/payslips',      [PayslipController::class, 'index']);
    Route::get('/payslips/{id}', [PayslipController::class, 'show']);
});
