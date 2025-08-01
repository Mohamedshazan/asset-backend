<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = $request->user()->role;

        // Treat 'Admin' and 'Super User' as equivalent
        if ($userRole === 'Super User') {
            $userRole = 'Admin';
        }

        if (!in_array($userRole, $roles)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return $next($request);
    }
}
