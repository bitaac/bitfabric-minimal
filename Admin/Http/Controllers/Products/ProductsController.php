<?php

namespace Bitaac\Admin\Http\Controllers\Products;

use Bitaac\Contracts\StoreProduct;
use Bitaac\Laravel\Http\Controllers\Controller;

class ProductsController extends Controller
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
     * [GET] /admin/products
     *
     * @param  \Bitaac\Contracts\StoreProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function get(StoreProduct $product)
    {
        return view('admin::products.index')->with([
            'products' => $product->all(),
        ]);
    }
}
