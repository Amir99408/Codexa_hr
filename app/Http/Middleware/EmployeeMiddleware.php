<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasRole('employee')) {
            if (auth()->check() && auth()->user()->hasRole('admin')) {
                return redirect()->route('dashboard');
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}