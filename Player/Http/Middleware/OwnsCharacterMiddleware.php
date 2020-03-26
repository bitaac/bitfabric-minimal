<?php

namespace Bitaac\Player\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OwnsCharacterMiddleware
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
        if (is_null($player = $request->route()->parameters()['player'])) {
            return (auth()->check()) ? redirect('/account') : redirect('/');
        }

        if ($player->account_id != auth()->user()->id) {
            return (auth()->check()) ? redirect('/account') : redirect('/');
        }

        return $next($request);
    }
}
