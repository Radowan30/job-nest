<?php
// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:applicant') or 'role:company'
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}

