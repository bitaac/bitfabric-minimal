<?php

namespace Bitaac\Core\Http\Middleware;

use Closure;
use Bitaac\Player\Models\BitaacPlayer;

class DeleteCharacterMiddleware
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
        $characters = BitaacPlayer::where(function ($query) {
            $query->where('deletion_time', '<', time());
            $query->where('deletion_time', '>', 0);
        })->get();

        $characters->each(function ($item) {
            $item->player->delete();
            $item->delete();
        });

        return $next($request);
    }
}
