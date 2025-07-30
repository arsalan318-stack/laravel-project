<?php

namespace App\Http\Middleware;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;


class UpdateLastSeen
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
        if (Auth::check()) {
            Auth::user()->update(['last_seen' => Carbon::now()]);
        }
        return $next($request);
    
    }    
}
