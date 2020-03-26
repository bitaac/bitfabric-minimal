<?php

namespace Bitaac\Admin\Http\Controllers\Products;

use Bitaac\Contracts\StoreProduct;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Admin\Http\Requests\Products\CreateRequest;

class CreateController extends Controller
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
     * [GET] /admin/products/create
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('admin::products.create');
    }

    /**
     * [POST] /admin/products/create
     *
     * @param  \Bitaac\Admin\Http\Requests\Products\CreateRequest  $request
     * @param  \Bitaac\Contracts\StoreProduct                      $product
     * @return \Illuminate\Http\Response
     */
    public function post(CreateRequest $request, StoreProduct $product)
    {
        $product->create($request->only([
            'title', 'item_id', 'count', 'points', 'description'
        ]));

        return redirect()->route('admin.products')->with([
            'success' => 'Your product has been added.',
        ]);
    }
}
