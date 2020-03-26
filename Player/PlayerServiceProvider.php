<?php

namespace Bitaac\Player;

use Illuminate\Http\Response;
use Bitaac\Player\Http\Middleware;
use Illuminate\Support\ServiceProvider;
use Bitaac\Player\Exceptions\NotFoundPlayerException;

class PlayerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Resources/Migrations');

        $this->publishes([
            __DIR__.'/Resources/Config' => config_path('bitaac'),
        ], 'bitaac:config');
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
            \Bitaac\Player\Resources\Seeds\DatabaseSeeder::class
        );

        $this->exceptions->handle(NotFoundPlayerException::class, function ($e) {
            return new Response(view('errors.404'), 404);
        });

        $this->app['router']->aliasMiddleware('character.exists', Middleware\CharacterExistsMiddleware::class);
        $this->app['router']->aliasMiddleware('owns.character', Middleware\OwnsCharacterMiddleware::class);

        $this->app->register(RouteServiceProvider::class);
    }
}
