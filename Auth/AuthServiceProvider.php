<?php

namespace Bitaac\Auth;

use Bitaac\Auth\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;
use Bitaac\Auth\LaravelAuthServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(LaravelAuthServiceProvider::class);
    }
}
