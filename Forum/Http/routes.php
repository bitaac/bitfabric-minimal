<?php

/*
|--------------------------------------------------------------------------
| /forum routes
|--------------------------------------------------------------------------
*/

$router->name('forum')->get('/', 'ForumController@index');
$router->name('forum.board')->get('/{board}', 'Board\ShowController@index');

$router->name('forum.thread.create')->get('/{board}/create', 'Thread\CreateController@form');
$router->post('/{board}/create', 'Thread\CreateController@post');

$router->name('forum.thread')->get('/{board}/{thread}', 'Thread\ShowController@index');

$router->name('forum.thread.lock')->get('/{board}/{thread}/lock', 'Thread\LockController@form');
$router->post('/{board}/{thread}/lock', 'Thread\LockController@post');

$router->name('forum.thread.unlock')->get('/{board}/{thread}/unlock', 'Thread\UnlockController@form');
$router->post('/{board}/{thread}/unlock', 'Thread\UnlockController@post');

$router->name('forum.thread.delete')->get('/{board}/{thread}/delete', 'Thread\DeleteController@form');
$router->post('/{board}/{thread}/delete', 'Thread\DeleteController@post');

$router->name('forum.thread.reply')->get('/{board}/{thread}/reply', 'Thread\ReplyController@index');
$router->post('/{board}/{thread}/reply', 'Thread\ReplyController@post');

$router->name('forum.thread.hotlink')->get('/{board}/{thread}#{reply}', 'Thread\ShowController@index');

/*
|--------------------------------------------------------------------------
| Model bindings
|--------------------------------------------------------------------------
*/

$router->model('board', Bitaac\Contracts\Forum\Board::class);
$router->model('thread', Bitaac\Contracts\Forum\Post::class);
