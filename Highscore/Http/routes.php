<?php

/*
|--------------------------------------------------------------------------
| /highscore routes
|--------------------------------------------------------------------------
|
| ...
|
*/

$router->group(['prefix' => '/highscore'], function ($router) {
    $router->name('highscores')->get('/{skill?}/{vocation?}', 'HighscoreController@index');
    $router->post('/{skill?}/{vocation?}', 'HighscoreController@post');
});
