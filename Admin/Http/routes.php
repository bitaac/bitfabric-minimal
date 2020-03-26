<?php

/*
|--------------------------------------------------------------------------
| /admin routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'AdminController')->name('admin');

Route::get('/payments', 'Payments\PaymentsController@get')->name('admin.payments');

Route::get('/products', 'Products\ProductsController@get')->name('admin.products');

Route::get('/products/create', 'Products\CreateController@get')->name('admin.products.create');
Route::post('/products/create', 'Products\CreateController@post');

Route::get('/products/edit/{product}', 'Products\EditController@get')->name('admin.product.edit');
Route::post('/products/edit/{product}', 'Products\EditController@post');

Route::get('/products/delete/{product}', 'Products\DeleteController@get')->name('admin.product.delete');
Route::post('/products/delete/{product}', 'Products\DeleteController@post');

Route::get('/boards', 'Boards\BoardsController@get')->name('admin.boards');

Route::get('/boards/create', 'Boards\CreateController@get')->name('admin.boards.create');
Route::post('/boards/create', 'Boards\CreateController@post');

Route::get('/boards/edit/{board}', 'Boards\EditController@get')->name('admin.board.edit');
Route::post('/boards/edit/{board}', 'Boards\EditController@post');

Route::get('/boards/delete/{board}', 'Boards\DeleteController@get')->name('admin.board.delete');
Route::post('/boards/delete/{board}', 'Boards\DeleteController@post');

Route::get('/accounts', 'Accounts\AccountsController@get')->name('admin.accounts');

Route::get('/account/{account}', 'Account\IndexController@get')->name('admin.account');
Route::post('/account/{account}', 'Account\IndexController@post');

Route::get('/account/{account}/edit', 'Account\EditController@get')->name('admin.account.edit');
Route::post('/account/{account}/edit', 'Account\EditController@post');

Route::get('/account/{account}/delete', 'Account\DeleteController@get')->name('admin.account.delete');
Route::post('/account/{account}/delete', 'Account\DeleteController@post');

Route::get('/account/{account}/impersonate', 'Account\ImpersonationController@impersonate')->name('admin.account.impersonate');
Route::get('/account/{account}/stopImpersonating', 'Account\ImpersonationController@stopImpersonating')->name('admin.account.impersonate.stop');

Route::get('/characters', 'Characters\CharactersController@get')->name('admin.characters');

Route::get('/terms', 'Misc\TermsController@get')->name('admin.terms');
Route::post('/terms', 'Misc\TermsController@post');


/*
|--------------------------------------------------------------------------
| Explicit bindings
|--------------------------------------------------------------------------
*/

Route::model('account', Bitaac\Contracts\Account::class);
