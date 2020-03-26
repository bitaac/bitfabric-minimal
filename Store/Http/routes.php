<?php

/*
|--------------------------------------------------------------------------
| /store routes
|--------------------------------------------------------------------------
|
|
*/

$router->group(['prefix' => '/store', 'middleware' => ['web']], function ($router) {
    $router->name('store')->get('/', 'StoreController@index');
    $router->name('store.claim')->get('/claim/{product}', 'ClaimController@form')->middleware(['auth', 'can.claim']);
    $router->post('/claim/{product}', 'ClaimController@post')->middleware(['auth', 'can.claim']);
    $router->name('store.offers')->get('/offers', 'Offer\OfferController@index');
    $router->name('store.gateway')->get('/offers/{gateway}', 'Offer\PaymentController@index');
    $router->post('/offers/{gateway}', 'Offer\PaymentController@post');
    $router->get('/offers/{gateway}/return', 'Offer\PaymentController@return')->name('gateway.return');
    $router->get('/offers/{gateway}/cancel', 'Offer\PaymentController@cancel')->name('gateway.cancel');
});

/*
|--------------------------------------------------------------------------
| Explicit bindings
|--------------------------------------------------------------------------
|
|
*/

$router->model('product', Bitaac\Contracts\StoreProduct::class);





