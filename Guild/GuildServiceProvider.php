<?php

namespace Bitaac\Guild;

use Illuminate\Http\Response;
use Bitaac\Guild\Http\Middleware;
use Illuminate\Support\ServiceProvider;
use Bitaac\Guild\Exceptions\NotFoundGuildException;

class GuildServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Resources/Config' => config_path('bitaac'),
        ], 'bitaac:config');

        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'bitaac');

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
            \Bitaac\Guild\Resources\Seeds\DatabaseSeeder::class
        );

        $this->exceptions->handle(NotFoundGuildException::class, function ($e) {
            return new Response(view('errors.404'), 404);
        });

        $this->app->register(RouteServiceProvider::class);

        $this->app['router']->aliasMiddleware('can.edit', Middleware\CanEditMiddleware::class);
        $this->app['router']->aliasMiddleware('can.invite', Middleware\CanInviteMiddleware::class);
        $this->app['router']->aliasMiddleware('has.owner', Middleware\HasOwnerMiddleware::class);
        $this->app['router']->aliasMiddleware('has.invite', Middleware\HasInviteMiddleware::class);
    }
}
