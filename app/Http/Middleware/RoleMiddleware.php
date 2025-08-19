<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
      public function handle(Request $request, Closure $next, $role): Response
    {
        // If user is not logged in or doesn't have the role, deny access
        if (!auth()->check() || !auth()->user()->hasRole($role)) {
            abort(403, 'មិនមានសិទ្ធិចូលទេ'); // "You do not have permission to access this page"
        }

        return $next($request);
    }

}
