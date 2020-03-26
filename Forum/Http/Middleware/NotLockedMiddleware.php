<?php

namespace Bitaac\Forum\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotLockedMiddleware
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
        $thread = $request->route()->parameters()['thread'];

        $account = auth()->user();

        if ($thread->locked and $account->bitaac->admin == 0) {
            return redirect($thread->link());
        }

        return $next($request);
    }
}
