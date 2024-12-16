<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestResponse
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Request Received:', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'payload' => $request->all(),
        ]);

        $response = $next($request);

        if ($response->isRedirect()) {
            Log::info('Redirecting to:', [
                'location' => $response->headers->get('Location'),
                'status_code' => $response->getStatusCode(),
            ]);
        }

        return $response;
    }
}

