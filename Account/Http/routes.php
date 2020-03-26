<?php

/*
|--------------------------------------------------------------------------
| other /account routes
|--------------------------------------------------------------------------
*/

$router->name('account')->get('/', 'AccountController@index');
$router->name('account.logout')->get('/logout', 'LogoutController@index');
$router->post('/logout', 'LogoutController@post');

/*
|--------------------------------------------------------------------------
| /account/password routes
|--------------------------------------------------------------------------
*/

$router->name('account.password')->get('/password', 'Change\PasswordController@form');
$router->post('/password', 'Change\PasswordController@post');

/*
|--------------------------------------------------------------------------
| /account/email routes
|--------------------------------------------------------------------------
*/

$router->name('account.email')->get('/email', 'Change\EmailController@form');
$router->post('/email', 'Change\EmailController@post');

/*
|--------------------------------------------------------------------------
| /account/character routes
|--------------------------------------------------------------------------
*/

$router->name('account.character')->get('/character', 'Character\CreateController@form');
$router->post('/character', 'Character\CreateController@post');

/*
|--------------------------------------------------------------------------
| /account/character/delete routes
|--------------------------------------------------------------------------
*/

$router->name('account.character.delete')->get('/character/delete', 'Character\DeleteController@form');
$router->post('/character/delete', 'Character\DeleteController@post');

/*
|--------------------------------------------------------------------------
| /account/undelete routes
|--------------------------------------------------------------------------
*/

$router->name('account.character.undelete')->get('/undelete/{player}', 'Character\UndeleteController@form');
$router->post('/undelete/{player}', 'Character\UndeleteController@post');

/*
|--------------------------------------------------------------------------
| /account/authentication routes
|--------------------------------------------------------------------------
*/

$router->name('account.authentication')->get('/authentication', 'Authentication\AuthenticationController@form');
$router->post('/authentication', 'Authentication\AuthenticationController@post');
