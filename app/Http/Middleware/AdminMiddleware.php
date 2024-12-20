<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            \Log::info('User not authenticated. Redirecting to login...');
            return redirect()->route('login');
        }
    
        if (!Auth::user()->is_admin) {
            \Log::info('User is not an admin. Aborting...');
            abort(403, 'Unauthorized');
        }
    
        \Log::info('User is an admin. Proceeding...');
        return $next($request);
    }
}
