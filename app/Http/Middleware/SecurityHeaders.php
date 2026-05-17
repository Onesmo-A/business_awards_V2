<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $isLocal = app()->environment(['local', 'development']);

        $scriptSources = [
            "'self'",
            "'unsafe-inline'",
            "'unsafe-eval'",
            'https://www.googletagmanager.com',
            'https://www.google-analytics.com',
        ];
        $connectSources = [
            "'self'",
            'https://www.google-analytics.com',
            'https://region1.google-analytics.com',
        ];
        $frameSources = [
            "'self'",
            'https://www.instagram.com',
            'https://www.google.com',
            'https://www.google.com/maps',
        ];

        if ($isLocal) {
            $scriptSources = array_merge($scriptSources, [
                'http://localhost:5173',
                'http://127.0.0.1:5173',
            ]);
            $connectSources = array_merge($connectSources, [
                'http://localhost:5173',
                'http://127.0.0.1:5173',
                'ws://localhost:5173',
                'ws://127.0.0.1:5173',
            ]);
        }

        $scriptSources = $this->appendEnvSources($scriptSources, env('CSP_SCRIPT_SRC_EXTRA', ''));
        $connectSources = $this->appendEnvSources($connectSources, env('CSP_CONNECT_SRC_EXTRA', ''));
        $frameSources = $this->appendEnvSources($frameSources, env('CSP_FRAME_SRC_EXTRA', ''));

        $csp = implode('; ', [
            "default-src 'self'",
            "base-uri 'self'",
            "object-src 'none'",
            "frame-ancestors 'none'",
            "form-action 'self'",
            'script-src '.implode(' ', array_unique($scriptSources)),
            'script-src-elem '.implode(' ', array_unique($scriptSources)),
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net",
            "font-src 'self' data: https://fonts.bunny.net",
            "img-src 'self' data: blob: https:",
            'connect-src '.implode(' ', array_unique($connectSources)),
            'frame-src '.implode(' ', array_unique($frameSources)),
            "worker-src 'self' blob:",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }

    private function appendEnvSources(array $sources, string $extra): array
    {
        $extraSources = preg_split('/\s+/', trim($extra)) ?: [];
        $extraSources = array_filter($extraSources, static fn ($value) => $value !== '');

        return array_merge($sources, $extraSources);
    }
}
