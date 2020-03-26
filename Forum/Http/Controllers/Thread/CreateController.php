<?php

namespace Bitaac\Forum\Http\Controllers\Thread;

use Bitaac\Contracts\Forum\Board;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Forum\Http\Requests\Thread\CreateRequest;

class CreateController extends Controller
{
    /**
     * Create a new create controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the create thread page.
     *
     * @param  \Bitaac\Contracts\Forum\Board $board
     * @return \Illuminate\Http\Response
     */
    public function form(Board $board)
    {
        return view('forum.thread.create', [
            'board' => $board,
        ]);
    }

    /**
     * Handle the create thread request.
     *
     * @param  \Bitaac\Forum\Http\Requests\Thread\CreateRequest  $request
     * @param  \Bitaac\Contracts\Forum\Board                      $board
     * @return \Illuminate\Http\Response
     */
    public function post(CreateRequest $request, Board $board)
    {
        $post = app('forum.post');
        $post->board_id = $board->id;
        $post->player_id = $request->get('author');
        $post->title = $request->title;
        $post->slug = str_slug($request->title);
        $post->content = $request->get('content');
        $post->timestamp = time();
        $post->save();

        return redirect()->route('forum.thread', [$board, $post]);
    }
}
