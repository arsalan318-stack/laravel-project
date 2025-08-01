<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LogoutIfUnverified
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
        {
            if(Auth::check() && Auth::user()->role =='admin'){
                return redirect()->route('admin1')->with('status', 'Please verify your email address.');            }

            }
            if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
                Auth::logout();
                
                return redirect()->route('verify.guest')->with('status', 'Please verify your email address.');            }

            return $next($request);
        }    
}
