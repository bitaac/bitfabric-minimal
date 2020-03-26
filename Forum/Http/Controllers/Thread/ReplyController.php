<?php

namespace Bitaac\Forum\Http\Controllers\Thread;

use Illuminate\Http\Request;
use Bitaac\Core\Rules\OwnsCharacter;
use Bitaac\Laravel\Http\Controllers\Controller;

class ReplyController extends Controller
{
    /**
     * Create a new reply controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'not.locked']);
    }

    /**
     * Show the thread reply form to the user.
     *
     * @param  string  $board
     * @param  string  $thread
     * @return \Illuminate\Http\Response
     */
    public function index($board, $thread)
    {
        return view('forum.thread.reply', [
            'thread' => $thread,
            'board'  => $board,
        ]);
    }

    /**
     * Process the thread reply.
     *
     * @param  string  $board
     * @param  string  $thread
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, $board, $thread)
    {
        $this->validate($request, [
            'author' => ['required', new OwnsCharacter],
            'content' => ['required', 'between:15,3000'],
        ]);

        $thread->timestamp = time();
        $thread->save();

        $post = app('forum.post');
        $post->title = $thread->title;
        $post->board_id = $board->id;
        $post->player_id = $request->get('author');
        $post->belongs_to = $thread->id;
        $post->content = $request->get('content');
        $post->timestamp = time();
        $post->save();

        return redirect(url_e('/forum/:board/:thread#:postId', [
            'board'  => $board->title,
            'thread' => $thread->title,
            'postId' => $post->id,
        ]));
    }
}
