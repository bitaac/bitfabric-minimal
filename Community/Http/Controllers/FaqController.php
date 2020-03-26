<?php

namespace Bitaac\Community\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Show the faq page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('community.faq');
    }
}
