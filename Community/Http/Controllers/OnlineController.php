<?php

namespace Bitaac\Community\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;

class OnlineController extends Controller
{
    /**
     * Show the onlinelist page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('community.online')->with([
            'players' => getOnlinePlayers(),
        ]);
    }
}
