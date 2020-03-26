<?php

namespace Bitaac\Store;

use Illuminate\Http\Response;
use Bitaac\Store\Http\Middleware;
use Illuminate\Support\ServiceProvider;
use Bitaac\Store\Exceptions\NotFoundProductException;

class StoreServiceProvider extends ServiceProvider
{
    /**
     * Holds all contracts and models we want to bind.
     *
     * @var array
     */
    protected $bindingsAndAliases = [
        'store.product' => [\Bitaac\Contracts\StoreProduct::class => \Bitaac\Store\Models\StoreProduct::class],
    ];

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

        foreach ($this->bindingsAndAliases as $alias => $binding) {
            list($abstract, $concrete) = [key($binding), current($binding)];

            $this->app->bind($abstract, $concrete);
            $this->app->alias($abstract, $alias);
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->exceptions = $this->app['Bitaac\Core\Exceptions\Handler'];

        $this->exceptions->handle(NotFoundProductException::class, function ($e) {
            return new Response(view('errors.404'), 404);
        });

        $this->app['router']->aliasMiddleware('can.claim', Middleware\CanClaimMiddleware::class);

        $this->app->register(RouteServiceProvider::class);
    }
}
