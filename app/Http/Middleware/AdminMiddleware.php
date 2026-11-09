<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Read the authenticated user from the request
        $user = $request->user();

        // 2. Return 401 if unauthenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        // 3. Return 403 if the user is not an admin ($user->role !== 'admin')
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized action. Admin access required.'
            ], 403);
        }

        // 4. Allow the request to continue only when $user->role === 'admin'
        return $next($request);
    }
}