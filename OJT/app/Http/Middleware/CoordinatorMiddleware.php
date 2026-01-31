<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CoordinatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'coordinator') {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}