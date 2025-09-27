<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDashboardToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $configuredToken = config('app.dashboard_token');
        $providedToken = $request->query('token') ?? $request->header('X-Dashboard-Token');

        if (!$configuredToken || !$providedToken || !hash_equals($configuredToken, (string) $providedToken)) {
            abort(403, 'Unauthorized dashboard access.');
        }

        return $next($request);
    }
}
