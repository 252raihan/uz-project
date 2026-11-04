<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds baseline security headers to every response.
 *
 * The Content-Security-Policy is written to match what the Milestone 1
 * prototype actually renders: Vite-built CSS/JS from this origin, inline
 * Blade/Alpine-free markup, and inline SVG icons. No third-party origins are
 * allowed. If the UI later adds webfonts, analytics, or inline scripts, this
 * policy must be extended deliberately and reviewed.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (config('platform.prototype', true)) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
        }

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy());
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // Unknown APIs/permissions are denied by default. The prototype uses none of them.
        $response->headers->set('Permissions-Policy', 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=(), interest-cohort=()');

        // Only meaningful over HTTPS; harmless on plain HTTP and avoids HSTS pinning localhost.
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }

    private function contentSecurityPolicy(): string
    {
        $directives = [
            'default-src' => "'self'",
            'base-uri' => "'self'",
            'object-src' => "'none'",
            'frame-ancestors' => "'none'",
            'form-action' => "'none'",
            'img-src' => "'self' data:",
            'font-src' => "'self' data:",
            'style-src' => "'self' 'unsafe-inline'",
            'script-src' => "'self'",
            'connect-src' => "'self'",
            'manifest-src' => "'self'",
            'media-src' => "'self'",
            'worker-src' => "'self'",
            'upgrade-insecure-requests' => null,
        ];

        $parts = [];

        foreach ($directives as $directive => $value) {
            $parts[] = $value === null ? $directive : $directive.' '.$value;
        }

        return implode('; ', $parts).';';
    }
}
