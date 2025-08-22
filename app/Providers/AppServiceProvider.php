<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for ngrok tunneling - detect and use correct URL when accessed through ngrok
        $proxies = config('trustedproxy.proxies');
        
        // If proxies is set to '*', trust all proxies
        if ($proxies === '*') {
            \Illuminate\Http\Request::setTrustedProxies(
                ['127.0.0.1', '::1', '*'],
                \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO
            );
        }
        
        // Force URLs to use the current scheme and host dynamically
        // Get the URL from request
        $host = request()->getHost();
        $scheme = request()->isSecure() ? 'https' : 'http';
        $rootUrl = $scheme . '://' . $host;
        
        // Set the correct URL for asset handling
        \URL::forceRootUrl($rootUrl);
        
        // If request is secure
        if (request()->isSecure()) {
            \URL::forceScheme('https');
        }
    }
}
