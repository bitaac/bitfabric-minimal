<?php

namespace Bitaac\Community\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;

class TermsController extends Controller
{
    /**
     * [GET] /terms
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('community.terms');
    }
}
