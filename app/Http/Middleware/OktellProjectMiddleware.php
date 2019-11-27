<?php

namespace App\Http\Middleware;

use Closure;

class OktellProjectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $project)
    {

        $request->user()->authorizeProjects($project);
        
        return $next($request);
    }
}
