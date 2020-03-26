<?php

/*
|--------------------------------------------------------------------------
| Invidual guild routes
|--------------------------------------------------------------------------
|
| ...
|
*/

$router->group(['prefix' => '/guild'], function ($router) {
    $router->name('guild')->get('/{guild}', 'Guild\ShowController@show');
    $router->name('guild.invite')->get('/{guild}/invite', 'Guild\Member\InviteController@form')->middleware(['can.invite']);
    $router->post('/{guild}/invite', 'Guild\Member\InviteController@post')->middleware(['can.invite']);
    $router->name('guild.join')->get('/{guild}/join', 'Guild\Member\JoinController@form')->middleware(['auth', 'has.invite']);
    $router->post('/{guild}/join', 'Guild\Member\JoinController@post')->middleware(['auth', 'has.invite']);
    $router->name('guild.cancel')->get('/{guild}/cancel', 'Guild\Member\CancelController@form')->middleware(['auth', 'can.invite']);
    $router->post('/{guild}/cancel', 'Guild\Member\CancelController@post')->middleware(['auth', 'can.invite']);
    $router->name('guild.disband')->get('/{guild}/disband', 'Guild\DisbandController@form')->middleware(['auth', 'has.owner']);
    $router->post('/{guild}/disband', 'Guild\DisbandController@post')->middleware(['auth', 'has.owner']);
    $router->name('guild.edit')->get('/{guild}/edit', 'Guild\EditController@form')->middleware(['auth', 'can.edit']);
    $router->post('/{guild}/edit', 'Guild\EditController@post')->middleware(['auth', 'can.edit']);
    $router->name('guild.leave')->get('/{guild}/leave', 'Guild\Member\LeaveController@form')->middleware(['auth']);
    $router->post('/{guild}/leave', 'Guild\Member\LeaveController@post')->middleware(['auth']);
    $router->name('guild.ranks')->get('/{guild}/ranks', 'Guild\RankController@form')->middleware(['auth', 'can.edit']);
    $router->post('/{guild}/ranks', 'Guild\RankController@post')->middleware(['auth', 'can.edit']);
    $router->name('guild.members')->get('/{guild}/members', 'Guild\Member\EditController@form')->middleware(['auth', 'can.edit']);
    $router->post('/{guild}/members', 'Guild\Member\EditController@post')->middleware(['auth', 'can.edit']);
    $router->name('guild.edit.deletelogo')->get('/{guild}/edit/deletelogo', 'Guild\EditController@deletelogo')->middleware(['auth', 'can.edit']);
});

/*
|--------------------------------------------------------------------------
| Generic guilds routes
|--------------------------------------------------------------------------
|
| ...
|
*/

$router->group(['prefix' => '/guilds'], function ($router) {
    $router->name('guild.logo')->get('/{guild}/logo', 'ShowController@logo');
    $router->name('guilds')->get('/', 'Guilds\GuildsController@index');
    $router->name('guilds.create')->get('/create', 'Guilds\CreateController@form')->middleware(['auth']);
    $router->post('/create', 'Guilds\CreateController@post')->middleware(['auth']);
});

/*
|--------------------------------------------------------------------------
| Explicit bindings
|--------------------------------------------------------------------------
|
|
*/

$router->model('guild', \Bitaac\Contracts\Guild::class);

