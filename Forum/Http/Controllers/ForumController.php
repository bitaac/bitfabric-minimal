<?php

namespace Bitaac\Forum\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Forum\Models\Board;

class ForumController extends Controller
{
    /**
     * Show the forum boards to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forum.index', [
            'boards' => Board::orderBy('order')->get(),
        ]);
    }
}
