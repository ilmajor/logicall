<?php

namespace App\Http\Middleware;

use Closure;
Use App\Models\Role;

class AuthEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->user()->authorizeRoles(Role::select('name')->whereNotNull('employee')->get()->toArray());
        return $next($request);
    }
}
