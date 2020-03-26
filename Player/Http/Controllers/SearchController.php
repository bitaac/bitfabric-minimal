<?php

namespace Bitaac\Player\Http\Controllers;

use Illuminate\Http\Request;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Player\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    /**
     * Show the character search form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('character.search');
    }

    /**
     * Search for a character.
     *
     * @param  \Bitaac\Player\Http\Requests\SearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(SearchRequest $request)
    {
        return redirect(url_e('/character/:name', ['name' => $request->get('name')]));
    }
}
