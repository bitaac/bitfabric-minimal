<?php

namespace Bitaac\Admin\Http\Controllers\Boards;

use Bitaac\Contracts\Forum\Board;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Admin\Http\Requests\Boards\EditRequest;

class EditController extends Controller
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
     * [GET] /admin/boards/edit/{board}
     *
     * @param  \Bitaac\Contracts\Forum\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function get(Board $board)
    {
        return view('admin::boards.edit')->with([
            'board' => $board,
        ]);
    }

    /**
     * [POST] /admin/boards/edit/{board}
     *
     * @param  \Bitaac\Admin\Http\Requests\Boards\EditRequest  $request
     * @param  \Bitaac\Contracts\Forum\Board                    $board
     * @return \Illuminate\Http\Response
     */
    public function post(EditRequest $request, Board $board)
    {
        $board->update($request->only([
            'title', 'order', 'description'
        ]));

        return redirect()->route('admin.board.edit', $board)->with([
            'success' => 'Your changes were saved.',
        ]);
    }
}
