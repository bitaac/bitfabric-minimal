<?php

namespace Bitaac\Forum\Http\Controllers\Thread;

use Illuminate\Http\Request;
use Bitaac\Laravel\Http\Controllers\Controller;

class UnlockController extends Controller
{
    /**
     * Create a new unlock controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the thread unlock form to the user.
     *
     * @param  \Bitaac\Forum\Board   $board
     * @param  \Bitaac\Forum\Post    $thread
     * @return \Illuminate\Http\Response
     */
    public function form($board, $thread)
    {
        if (! $thread->locked) {
            return redirect(url_e('/forum/:board/:thread', [
                'thread' => $thread->title,
                'board'  => $board->title,
            ]));
        }

        return view('forum.thread.unlock', compact('board', 'thread'));
    }

    /**
     * Process the thread unlock.
     *
     * @param  \Bitaac\Forum\Board   $board
     * @param  \Bitaac\Forum\Post    $thread
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, $board, $thread)
    {
        $thread->unlock();

        return redirect($thread->link())->withSuccess("You have successfully unlocked thread {$thread->title}.");
    }
}
