<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
/**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in AND their 'is_admin' database column is true (1)
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // If they are not an admin, block access completely with a clear error response
        abort(403, 'Access denied. This system is strictly reserved for Admin use only.');
    }