<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userRole = Auth::user()?->role?->name;

        if (!in_array($userRole, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
