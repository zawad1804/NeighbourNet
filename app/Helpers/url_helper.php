<?php

if (!function_exists('secure_url_asset')) {
    /**
     * Generate a secure URL for an asset regardless of the current scheme.
     * This helper is particularly useful when dealing with ngrok tunnels.
     *
     * @param  string  $path
     * @return string
     */
    function secure_url_asset($path)
    {
        // Get the URL from request
        $host = request()->getHost();
        $isNgrok = str_contains($host, 'ngrok');
        
        // For ngrok or secured connections, ensure HTTPS
        if ($isNgrok || request()->isSecure()) {
            return 'https://' . $host . '/' . ltrim($path, '/');
        }
        
        // For regular local development
        return asset($path);
    }
}

if (!function_exists('is_ngrok')) {
    /**
     * Check if the current request is coming through ngrok
     *
     * @return bool
     */
    function is_ngrok()
    {
        return str_contains(request()->getHost(), 'ngrok');
    }
}
