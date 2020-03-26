<?php

namespace Bitaac\Community\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Community\Http\Responses\IndexResponse;

class IndexController extends Controller
{
    /**
     * Show the index page to the user.
     *
     * @return \Bitaac\Community\Http\Responses\IndexResponse
     */
    public function index()
    {
        return new IndexResponse();
    }
}
