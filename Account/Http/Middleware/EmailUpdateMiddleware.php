<?php

namespace Bitaac\Account\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmailUpdateMiddleware
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
        $user = auth()->user();

        if ($user->hasPendingEmail() && time() > $user->bitaac->email_change_time) {
            $user->updateEmailWithPending();
        }

        return $next($request);
    }
}
