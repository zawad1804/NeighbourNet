<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleNgrok
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if we're using ngrok
        $host = $request->getHost();
        $isNgrok = str_contains($host, 'ngrok');
        
        if ($isNgrok) {
            // Set headers to make ngrok work properly with Laravel
            $scheme = $request->header('X-Forwarded-Proto', $request->getScheme());
            $request->server->set('HTTPS', $scheme === 'https');
            
            // Set the session cookie to be secure if using https
            if ($scheme === 'https') {
                config(['session.secure' => true]);
            }
        }
        
        return $next($request);
    }
}
