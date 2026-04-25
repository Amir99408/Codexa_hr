<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /** Roles that can access the admin panel */
    private const MANAGEMENT_ROLES = ['admin', 'hr_manager', 'finance', 'dept_manager'];

    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasAnyRole(self::MANAGEMENT_ROLES)) {
            if (auth()->user()->hasRole('employee')) {
                return redirect()->route('employee.dashboard');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
