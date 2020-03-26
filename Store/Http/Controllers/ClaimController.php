<?php

namespace Bitaac\Store\Http\Controllers;

use Illuminate\Http\Request;
use Bitaac\Contracts\StoreProduct;
use Bitaac\Store\Models\StoreOrder;
use Bitaac\Laravel\Http\Controllers\Controller;

class ClaimController extends Controller
{
    /**
     * Show the product claim form to user.
     *
     * @param  \Bitaac\Store\Models\StoreProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function form(StoreProduct $product)
    {
        return view('store.claim')->with(compact('product'));
    }

    /**
     * Process the product claim request.
     *
     * @param  \Illuminate\Http\Request           $request
     * @param  \Bitaac\Store\Models\StoreProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, StoreProduct $product)
    {
        $user = $request->user();

        $order = new StoreOrder;
        $order->account_id = $request->user()->id;
        $order->player_id = $request->get('character');
        $order->item_id = $product->item_id;
        $order->count = $product->count;
        $order->save();

        $user->bitaac->points = $user->bitaac->points - $product->points;
        $user->bitaac->save();

        return redirect('/store')->withSuccess('Thanks for your purchase!');
    }
}
