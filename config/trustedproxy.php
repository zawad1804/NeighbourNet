<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Set trusted proxy IP addresses. Both IPv4 and IPv6 addresses are
    | supported, along with CIDR notation. The "*" character is syntactic sugar
    | within TrustedProxy to trust any proxy that connects directly to your
    | server, a requirement when using services like ngrok or Cloudflare.
    |
    */

    'proxies' => '*',

    /*
    |--------------------------------------------------------------------------
    | Proxied Headers
    |--------------------------------------------------------------------------
    |
    | This headers would be passed along from the proxy server to the request.
    |
    */

    'headers' => [
        Illuminate\Http\Request::HEADER_FORWARDED => 'FORWARDED',
        Illuminate\Http\Request::HEADER_X_FORWARDED_FOR => 'X-FORWARDED-FOR',
        Illuminate\Http\Request::HEADER_X_FORWARDED_HOST => 'X-FORWARDED-HOST',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PORT => 'X-FORWARDED-PORT',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO => 'X-FORWARDED-PROTO',
    ],
];
