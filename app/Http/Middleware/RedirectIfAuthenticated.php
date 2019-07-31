<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            //dd($guard);
            return redirect('/home');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/userId');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/statisticsId');
        }

        return $next($request);
    }
}
