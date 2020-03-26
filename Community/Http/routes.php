<?php

/*
|--------------------------------------------------------------------------
| General Community Routes
|--------------------------------------------------------------------------
*/

Route::name('index')->get('/', 'IndexController@index');
Route::name('online')->get('/online', 'OnlineController@index');
Route::name('deaths')->get('/deaths', 'DeathsController@index');
Route::name('faq')->get('/faq', 'FaqController@index');
Route::name('terms')->get('/terms', 'TermsController@get');
