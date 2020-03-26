<?php

namespace Bitaac\Admin\Http\Controllers\Products;

use Bitaac\Contracts\StoreProduct;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Admin\Http\Requests\Products\EditRequest;

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
     * [GET] /admin/products/edit/{product}
     *
     * @param  \Bitaac\Contracts\StoreProduct $product
     * @return \Illuminate\Http\Response
     */
    public function get(StoreProduct $product)
    {
        return view('admin::products.edit')->with([
            'product' => $product,
        ]);
    }

    /**
     * [POST] /admin/products/edit/{product}
     *
     * @param  \Bitaac\Contracts\StoreProduct                    $product
     * @param  \Bitaac\Admin\Http\Requests\Products\EditRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(EditRequest $request, StoreProduct $product)
    {
        $product->update($request->only([
            'title', 'item_id', 'count', 'points', 'description'
        ]));

        return redirect()->route('admin.product.edit', $product)->with([
            'success' => 'Your changes were saved.',
        ]);
    }
}
