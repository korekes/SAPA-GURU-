<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        

        if (!Auth::check()) {
            abort(403);
        }

        if (Auth::user()->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}