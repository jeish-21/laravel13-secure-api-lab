<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Read the authenticated user
        $user = $request->user();

        // 2. Return JSON with HTTP 401 if there is no authenticated user
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        // 3. Check whether the user's role is among the allowed $roles
        if (!in_array($user->role, $roles, true)) {
            // 4. Return JSON with HTTP 403 if the role is not allowed
            return response()->json([
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // 5. Call return $next($request); if the role is permitted
        return $next($request);
    }
}