<?php

namespace Bitaac\Player\Http\Middleware;

use Closure;

class CharacterExistsMiddleware
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
        if (is_null($request->route()->parameters()['player'])) {
            return redirect('/');
        }

        return $next($request);
    }
}
