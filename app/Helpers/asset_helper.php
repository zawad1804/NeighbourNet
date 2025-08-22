<?php

if (!function_exists('ngrok_asset')) {
    /**
     * Generate an asset path that works with both local development and ngrok tunnels.
     *
     * @param string $path
     * @return string
     */
    function ngrok_asset($path)
    {
        // Get the request protocol (http or https)
        $protocol = request()->secure() ? 'https' : 'http';
        
        // Get the host (domain) from the current request
        $host = request()->getHost();
        
        // Build the full URL to the asset
        return $protocol . '://' . $host . '/' . ltrim($path, '/');
    }
}
