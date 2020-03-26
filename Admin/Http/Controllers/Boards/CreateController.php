<?php

namespace Bitaac\Admin\Http\Controllers\Boards;

use Bitaac\Contracts\Forum\Board;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Admin\Http\Requests\Boards\CreateRequest;

class CreateController extends Controller
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
     * [GET] /admin/boards/create
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('admin::boards.create');
    }

    /**
     * [POST] /admin/boards/create
     *
     * @param  \Bitaac\Admin\Http\Requests\Boards\CreateRequest  $request
     * @param  \Bitaac\Contracts\Forum\Board                      $board
     * @return \Illuminate\Http\Response
     */
    public function post(CreateRequest $request, Board $board)
    {
        $board = tap(new $board, function ($board) use ($request) {
            $board->title = $request->get('title');
            $board->slug = str_slug($request->get('title'));
            $board->order = ($request->has('order')) ? $request->get('order') : 0;
            $board->description = $request->get('description');
            $board->save();
        });

        return redirect()->route('admin.boards')->with([
            'success' => 'Your board has been created.',
            'board' => $board,
        ]);
    }
}
