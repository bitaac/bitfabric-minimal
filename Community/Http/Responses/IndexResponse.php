<?php

namespace Bitaac\Community\Http\Responses;

use Bitaac\Forum\Models\Board;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{
    /**
     * Get all news articles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function articles()
    {
        return Board::where('news', 1)->first()->threads;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return view('home.index')->with([
            'articles' => $this->articles(),
        ]);
    }
}
