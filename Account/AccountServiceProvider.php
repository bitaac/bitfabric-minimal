<?php

namespace Bitaac\Account;

use Bitaac\Account\Http\Middleware;
use Illuminate\Support\ServiceProvider;
use Bitaac\Account\RouteServiceProvider;

class AccountServiceProvider extends ServiceProvider
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
            __DIR__.'/Resources/Config' => config_path(),
        ], 'bitaac:config');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app['seed.handler']->register(
            \Bitaac\Account\Resources\Seeds\DatabaseSeeder::class
        );

        $this->app->register(RouteServiceProvider::class);

        $this->app['router']->aliasMiddleware('email.update', Middleware\EmailUpdateMiddleware::class);
    }
}
