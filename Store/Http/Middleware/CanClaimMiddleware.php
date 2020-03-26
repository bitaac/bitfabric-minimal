<?php

namespace Bitaac\Store\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CanClaimMiddleware
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
        if ($request->user()->bitaac->points < $request->product->points) {
            return redirect('/store');
        }
        
        return $next($request);
    }
}
