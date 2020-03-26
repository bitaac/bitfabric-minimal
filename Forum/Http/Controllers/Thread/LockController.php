<?php

namespace Bitaac\Forum\Http\Controllers\Thread;

use Illuminate\Http\Request;
use Bitaac\Laravel\Http\Controllers\Controller;

class LockController extends Controller
{
    /**
     * Create a new lock controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the thread lock form to the user.
     *
     * @param  \Bitaac\Forum\Board   $board
     * @param  \Bitaac\Forum\Post    $thread
     * @return \Illuminate\Http\Response
     */
    public function form($board, $thread)
    {
        if ($thread->locked) {
            return redirect(url_e('/forum/:board/:thread', [
                'thread' => $thread->title,
                'board'  => $board->title,
            ]));
        }

        return view('forum.thread.lock', [
            'thread' => $thread,
            'board'  => $board,
        ]);
    }

    /**
     * Process the thread lock.
     *
     * @param  \Bitaac\Forum\Board   $board
     * @param  \Bitaac\Forum\Post    $thread
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, $board, $thread)
    {
        $thread->lock();

        return redirect(url_e('/forum/:board/:thread', [
            'board'  => $board->title,
            'thread' => $thread->title,
        ]))->withSuccess('Thread has been locked.');
    }
}
