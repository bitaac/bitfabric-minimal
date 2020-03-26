<?php

namespace Bitaac\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $amount
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! auth()->check() or ! auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return $next($request);
    }
}
