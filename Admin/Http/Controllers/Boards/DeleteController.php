<?php

namespace Bitaac\Admin\Http\Controllers\Boards;

use Bitaac\Contracts\Forum\Board;
use Bitaac\Laravel\Http\Controllers\Controller;

class DeleteController extends Controller
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
     * [GET] /admin/boards/delete/{board}
     *
     * @param  \Bitaac\Contracts\Forum\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function get(Board $board)
    {
        return view('admin::boards.delete')->with([
            'board' => $board,
        ]);
    }

    /**
     * [POST] /admin/boards/delete/{board}
     *
     * @param  \Bitaac\Forum\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function post(Board $board)
    {
        $board->delete();

        return redirect()->route('admin.boards')->with([
            'success' => 'Your board has been deleted.',
        ]);
    }
}
