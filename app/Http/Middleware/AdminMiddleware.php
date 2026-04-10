<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            if (auth()->check() && auth()->user()->hasRole('employee')) {
                return redirect()->route('employee.dashboard');
            }
            return redirect()->route('login');
        }
        return $next($request);
    }
}