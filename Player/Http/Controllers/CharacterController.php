<?php

namespace Bitaac\Player\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class CharacterController extends Controller
{
    /**
     * Create a new character controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Show the character page to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($player)
    {
        $deaths = $player->deaths;

        return view('character.view')->with(compact('player', 'deaths'));
    }
}
