<?php

/*
|--------------------------------------------------------------------------
| /character routes
|--------------------------------------------------------------------------
|
|
*/

$router->group(['prefix' => '/character'], function ($router) {
    $router->name('character.search')->get('/', 'SearchController@form');
    $router->post('/', 'SearchController@post');
    $router->name('character')->get('/{player}', 'CharacterController@index');
});

/*
|--------------------------------------------------------------------------
| Model bindings
|--------------------------------------------------------------------------
|
|
*/

$router->model('player', \Bitaac\Contracts\Player::class);

