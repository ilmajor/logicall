<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\Models\UrlLog;

class HttpLog
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
        $log = New UrlLog;
        #$log->description = 
        #$log->origin = 
        $log->type = 'url';
        $log->result = $request->url();
        #$log->token = 
        $log->ip = $request->ip();
        $log->user_agent = Auth::id();
        #$log->session = 
        $log->save();
        return $next($request);
    }
}
