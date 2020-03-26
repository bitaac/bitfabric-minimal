<?php

namespace Bitaac\Admin\Http\Controllers;

use Bitaac\Contracts\Player;
use Bitaac\Contracts\Account;
use Bitaac\Laravel\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    
    /**
     * Show the adminpanel index page.
     *
     * @param  \Bitaac\Contracts\Account  $account
     * @param  \Bitaac\Contracts\Player   $player
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Account $account, Player $player)
    {
        $players = $player->all();

        $highestLevel = ($players->count() > 0) ? $players->sortByDesc('level')->first()->level : 0 ;

        $averageLevel = ($players->count() > 0) ? number_format($players->pluck('level')->avg()) : 0 ;

        return view('admin::index')->with([
            'totalAccounts' => $account->count(),
            'totalPlayers'  => $players->count(),
            'highestLevel'  => $highestLevel,
            'averageLevel'  => $averageLevel,
        ]);
    }
}
