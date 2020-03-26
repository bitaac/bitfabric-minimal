<?php

namespace Bitaac\Store\Http\Controllers\Offer;

use Bitaac\Laravel\Http\Controllers\Controller;

class OfferController extends Controller
{
    /**
     * Show the offers to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('store.offers.index');
    }
}
