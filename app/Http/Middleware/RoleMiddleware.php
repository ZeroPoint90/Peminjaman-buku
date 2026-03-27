<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role->value;

        if (!in_array($userRole, $roles)) {
            abort(403);
        }

        // dd(
        //     'User role:',
        //     Auth::user()?->role,
        //     'Role value:',
        //     Auth::user()?->role?->value,
        //     'Allowed roles:',
        //     $roles
        // );

        return $next($request);
    }
}
