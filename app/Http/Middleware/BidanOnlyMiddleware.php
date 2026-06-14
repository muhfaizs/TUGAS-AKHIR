<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BidanOnlyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || (! $request->user()->isBidanOnly() && ! $request->user()->isSuperAdmin())) {
            abort(403, 'Akses ditolak. Hanya Bidan dan Super Admin yang dapat mengelola data ibu hamil.');
        }

        return $next($request);
    }
}
