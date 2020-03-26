<?php

namespace Bitaac\Core\Providers;

use Auth;
use Validator;
use Bitaac\Core\Console\Commands;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('account', auth()->user());
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeAdminCommand::class,
            ]);
        }

        include __DIR__.'/../validator.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
