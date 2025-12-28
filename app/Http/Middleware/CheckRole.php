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
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if ( ! $user) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized.');
        }

        if (!in_array($user->role, $roles)) {
            abort(Response::HTTP_FORBIDDEN, 'Forbidden: unrecognized role.');
        }

        return $next($request);
    }
}
