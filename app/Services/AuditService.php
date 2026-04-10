<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditService
{
    public static function log(
        string  $action,
        string  $model,
        string  $description,
        ?int    $modelId   = null,
        ?array  $oldValues = null,
        ?array  $newValues = null,
    ): void {
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model'       => $model,
            'model_id'    => $modelId,
            'description' => $description,
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip'          => request()->ip(),
        ]);
    }
}
