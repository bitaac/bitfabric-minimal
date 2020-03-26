<?php

namespace Bitaac\Core\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\AggregateServiceProvider as ServiceProvider;

abstract class AggregateServiceProvider extends ServiceProvider
{
    /**
     * Holds the Exceptions Handler implementation.
     *
     * @var App\Exceptions\Handler
     */
    protected $exceptions;

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [];

    /**
     * The application's global middleware.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * The binding class names & alias.
     *
     * @var array
     */
    protected $bindingsAndAliases = [];

    /**
     * The commands class names.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * The provider migration paths.
     *
     * @var array
     */
    protected $migrations = [];

    /**
     * The provider routes file paths.
     *
     * @var array
     */
    protected $routes = [];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $events = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * Create a new service provider instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->exceptions = $app['Bitaac\Core\Exceptions\Handler'];
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
        $this->loadMigrations();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->instances = [];

        $this->registerMiddleware();
        $this->registerRouteMiddleware();
        $this->registerProviders();
        $this->registerBindingsAndAliases();
        $this->registerCommands();
        $this->registerEvents();
    }

    /**
     * Register application's global HTTP middleware.
     *
     * @return void
     */
    public function registerMiddleware()
    {
        if (empty($this->middleware)) {
            return;
        }

        $kernel = app('\Illuminate\Contracts\Http\Kernel');

        array_walk($this->middleware, function ($class) use ($kernel) {
            $kernel->prependMiddleware($class);
            $kernel->pushMiddleware($class);
        });
    }

    /**
     * Register application's route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        if (empty($this->routeMiddleware)) {
            return;
        }

        array_walk($this->routeMiddleware, function ($class, $name) {
            $this->app['router']->aliasMiddleware($name, $class);
        });
    }

    /**
     * Register providers.
     *
     * @return void
     */
    protected function registerProviders()
    {
        if (! isset($this->providers)) {
            return;
        }

        foreach ($this->providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }
    }

    /**
     * Register bindings.
     *
     * @return void
     */
    protected function registerBindingsAndAliases()
    {
        if (! isset($this->bindingsAndAliases)) {
            return;
        }

        foreach ($this->bindingsAndAliases as $alias => $binding) {
            list($abstract, $concrete) = [key($binding), current($binding)];

            $this->app->bind($abstract, $concrete);
            $this->app->alias($abstract, $alias);
        }
    }

    /**
     * Register commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->commands($this->commands);
    }

    /**
     * Load migration paths.
     *
     * @return void
     */
    public function loadMigrations()
    {
        foreach ($this->migrations as $migration) {
            $this->loadMigrationsFrom($migration);
        }
    }

    /**
     * Load routes files.
     *
     * @return void
     */
    public function loadRoutes()
    {
        foreach ($this->routes as $key => $route) {
            if ($this->app->routesAreCached()) {
                continue;
            }

            Route::group([
                'middleware' => 'web',
                'namespace'  => $key,
            ], function ($router) use ($route) {
                foreach ((array) $route as $path) {
                    require $path;
                }
            });
        }
    }

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function registerEvents()
    {
        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }
}
