<?php

namespace Bitaac\Admin;

use Bitaac\Admin\Http\Middleware;
use Illuminate\Support\Facades\View;
use Bitaac\Admin\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $navbar = resolve('Bitaac\Admin\Navbar\Navbar');

        View::composer('admin::layouts.app', function ($view) use ($navbar) {
            $view->with('navbar', $navbar);
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Bitaac\Admin\Navbar\Navbar', function () {
            return new \Bitaac\Admin\Navbar\Navbar;
        });

        $this->app->register(RouteServiceProvider::class);

        $this->app['router']->aliasMiddleware('admin', Middleware\AdminMiddleware::class);
    }
}
