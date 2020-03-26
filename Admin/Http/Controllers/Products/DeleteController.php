<?php

namespace Bitaac\Admin\Http\Controllers\Products;

use Bitaac\Contracts\StoreProduct;
use Bitaac\Laravel\Http\Controllers\Controller;

class DeleteController extends Controller
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
     * [GET] /admin/products/delete/{product}
     *
     * @param  \Bitaac\Contracts\StoreProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function get(StoreProduct $product)
    {
        return view('admin::products.delete')->with([
            'product' => $product,
        ]);
    }

    /**
     * [POST] /admin/products/delete/{product}
     *
     * @param  \Bitaac\Contracts\StoreProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function post(StoreProduct $product)
    {
        $product->delete();

        return redirect()->route('admin.products')->with([
            'success' => 'Your product has been deleted.',
        ]);
    }
}
