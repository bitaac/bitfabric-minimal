<?php

/*
|--------------------------------------------------------------------------
| /login routes
|--------------------------------------------------------------------------
*/

$router->name('login')->get('/login', 'LoginController@form');
$router->post('/login', 'LoginController@post');

/*
|--------------------------------------------------------------------------
| /register routes
|--------------------------------------------------------------------------
*/

$router->name('register')->get('/register', 'RegisterController@form');
$router->post('/register', 'RegisterController@post');
