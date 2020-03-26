<?php

namespace Bitaac\Highscore\Http\Controllers;

use Illuminate\Http\Request;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Core\Contracts\Highscore;

class HighscoreController extends Controller
{
    /**
     * Show the highscore page to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($skill = false, $vocation = false)
    {
        $highscore = app('highscore')->register($skill, $vocation);

        $vocation = vocation($vocation, true);

        return view('community.highscores')->with(compact('highscore', 'skill', 'vocation'));
    }

    /**
     * Show the highscore page to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        return redirect(url_e('/highscore/:skill/:vocation', ['skill' => $request->get('skill'), 'vocation' => vocation($request->get('vocation'))]));
    }
}
