<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Force JSON response for API routes
        if ($request->is('api/*') && !$response->headers->has('Content-Type')) {
            $response->headers->set('Content-Type', 'application/json');
        }
    
        return $response;
    }
}
