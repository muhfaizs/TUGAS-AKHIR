<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BypassAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            $user = User::first();
            if (!$user) {
                // Return immediate so it doesn't crash if no DB
                return $next($request);
            }
            Auth::login($user);
        }

        return $next($request);
    }
}
