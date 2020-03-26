<?php

namespace Bitaac\Forum\Http\Controllers\Thread;

use Bitaac\Contracts\Forum\Post;
use Bitaac\Contracts\Forum\Board;
use Bitaac\Laravel\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Show the thread to user.
     *
     * @param  \Bitaac\Contracts\Forum\Board   $board
     * @param  \Bitaac\Contracts\Forum\Post    $post
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board, Post $post)
    {
        $posts = $post->replies()->paginate(10);

        if ($post->lastip != $ip = ip2long(request()->ip())) {
            $post->lastip = $ip;
            $post->views = $post->views + 1;
            $post->save();
        }

        return view('forum.thread.show', [
            'thread' => $post,
            'board'  => $board,
            'posts'  => $posts,
            'offset' => ($posts->currentPage() * $posts->perPage()) - $posts->perPage(),
        ]);
    }
}
