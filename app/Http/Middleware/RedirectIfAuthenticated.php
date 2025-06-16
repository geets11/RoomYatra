<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('subadmin')) {
                    return redirect()->route('subadmin.dashboard');
                } elseif ($user->hasRole('landlord')) {
                    return redirect()->route('landlord.dashboard');
                } else if ($user->hasRole('tenant')) {
                    return redirect()->route('tenant.dashboard');
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
