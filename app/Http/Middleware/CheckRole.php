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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role === 'landlord' && !$request->user()->isLandlord()) {
            return redirect()->route('dashboard');
        }

        if ($role === 'tenant' && !$request->user()->isTenant()) {
            return redirect()->route('dashboard');
        }

        if ($role === 'admin' && !$request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        if ($role === 'subadmin' && !$request->user()->isSubadmin()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
