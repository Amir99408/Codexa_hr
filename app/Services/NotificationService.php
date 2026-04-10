<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    // Send to a specific user
    public static function send(
        int    $userId,
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
    ): void {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'url'     => $url,
        ]);
    }

    // Send to all admins
    public static function notifyAdmins(
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
    ): void {
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            self::send($admin->id, $title, $message, $type, $url);
        }
    }

    // Send to a specific employee's user account
    public static function notifyEmployee(
        int    $employeeId,
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
    ): void {
        $employee = \App\Models\Employee::find($employeeId);
        if ($employee?->user_id) {
            self::send($employee->user_id, $title, $message, $type, $url);
        }
    }
}