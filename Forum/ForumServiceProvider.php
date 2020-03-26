<?php

namespace Bitaac\Forum;

use Bitaac\Forum\Exceptions;
use Illuminate\Http\Response;
use Bitaac\Forum\Http\Middleware;
use Bitaac\Forum\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider
{
    /**
     * Holds all contracts and models we want to bind.
     *
     * @var array
     */
    protected $bindingsAndAliases = [
        'forum.post'  => [\Bitaac\Contracts\Forum\Post::class  => \Bitaac\Forum\Models\Post::class],
        'forum.board' => [\Bitaac\Contracts\Forum\Board::class => \Bitaac\Forum\Models\Board::class],
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Resources/Migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->exceptions = $this->app['Bitaac\Core\Exceptions\Handler'];

        $this->app['seed.handler']->register(
            \Bitaac\Forum\Resources\Seeds\DatabaseSeeder::class
        );

        $this->exceptions->handle(Exceptions\NotFoundBoardException::class, function ($e) {
            return new Response(view('errors.404'), 404);
        });

        $this->exceptions->handle(Exceptions\NotFoundThreadException::class, function ($e) {
            return new Response(view('errors.404'), 404);
        });

        $this->app->register(RouteServiceProvider::class);

        $this->app['router']->aliasMiddleware('not.locked', Middleware\NotLockedMiddleware::class);

        foreach ($this->bindingsAndAliases as $alias => $binding) {
            list($abstract, $concrete) = [key($binding), current($binding)];

            $this->app->bind($abstract, $concrete);
            $this->app->alias($abstract, $alias);
        }
    }
}
