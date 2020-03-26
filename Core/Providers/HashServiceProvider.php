<?php

namespace Bitaac\Core\Providers;

use Bitaac\Libraries\SHAHasher;
use Illuminate\Hashing\HashServiceProvider as ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hash', function () {
            return new SHAHasher;
        });
    }
}
