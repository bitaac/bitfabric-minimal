<?php

namespace Bitaac\Community\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;

class DeathsController extends Controller
{
    /**
     * Show the latest deaths page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deaths = app('death')->orderBy('time', 'desc');

        $limit = config('bitaac.community.deaths-per-page', 10);

        if (config('bitaac.community.deaths-pagination', true)) {
            $deaths = $deaths->paginate($limit);
        } else {
            $deaths = $deaths->limit($limit)->get();
        }

        return view('community.deaths')->with([
            'deaths' => $deaths,
        ]);
    }
}
