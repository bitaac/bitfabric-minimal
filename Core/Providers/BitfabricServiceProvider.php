<?php

namespace Bitaac\Core\Providers;

use Bitaac\Contracts;
use Illuminate\Http\Response;
use Bitaac\Auth\AuthServiceProvider;
use Bitaac\Theme\ThemeServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Bitaac\Admin\AdminServiceProvider;
use Bitaac\Guild\GuildServiceProvider;
use Bitaac\Store\StoreServiceProvider;
use Bitaac\Forum\ForumServiceProvider;
use Illuminate\Support\ServiceProvider;
use Bitaac\Player\PlayerServiceProvider;
use Bitaac\Laravel\LaravelServiceProvider;
use Bitaac\Account\AccountServiceProvider;
use Bitaac\Highscore\HighscoreServiceProvider;
use Bitaac\Community\CommunityServiceProvider;
use Bitaac\Core\Console\Commands\MigrateCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BitfabricServiceProvider extends ServiceProvider
{
    /**
     * The binding class names & alias.
     *
     * @var array
     */
    protected $bindingsAndAliases = [
        'account'        => [Contracts\Account::class   => \Bitaac\Account\Models\Account::class],
        'player'         => [Contracts\Player::class    => \Bitaac\Player\Models\Player::class],
        'death'          => [Contracts\Death::class     => \Bitaac\Death\Models\Death::class],
        'online'         => [Contracts\Online::class    => \Bitaac\Player\Models\Online::class],
        'highscore'      => [Contracts\Highscore::class => \Bitaac\Highscore\Models\Highscore::class],
        'player.storage' => [Contracts\PlayerStorage::class => \Bitaac\Player\Models\PlayerStorage::class],

        // Guild
        'guild'        => [Contracts\Guild::class       => \Bitaac\Guild\Models\Guild::class],
        'guild.member' => [Contracts\GuildMember::class => \Bitaac\Guild\Models\GuildMember::class],
        'guild.rank'   => [Contracts\GuildRank::class   => \Bitaac\Guild\Models\GuildRank::class],
        'guild.invite' => [Contracts\GuildInvite::class => \Bitaac\Guild\Models\GuildInvite::class],
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Resources/Migrations');

        $kernel = app('Illuminate\Contracts\Http\Kernel');
        $kernel->prependMiddleware(\Bitaac\Core\Http\Middleware\DeleteCharacterMiddleware::class);
        $kernel->pushMiddleware(\Bitaac\Core\Http\Middleware\DeleteCharacterMiddleware::class);

        if (config('bitaac.app.https')) {
            $this->app['url']->forceSchema('https');
        }

        $this->publishes([
            __DIR__.'/../Config' => config_path('bitaac'),
        ], 'bitaac:config');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        config([
            'view.paths' => [app_path('themes/'.config('bitaac.app.theme').'/views')]
        ]);

        $this->exceptions = $this->app['Bitaac\Core\Exceptions\Handler'];

        $aliasloader = AliasLoader::getInstance();
        $aliasloader->alias('Omnipay', \Barryvdh\Omnipay\Facade::class);

        if (config('bitaac.account.two-factor', false)) {
            $this->app->register(\PragmaRX\Google2FA\Vendor\Laravel\ServiceProvider::class);
            $aliasloader->alias('Google2FA', \PragmaRX\Google2FA\Vendor\Laravel\Facade::class);
        }

        $this->app->register(\Seedster\SeedsterServiceProvider::class);

        $this->app->booted(function () {
            $this->app->register(config('bitaac.app.theme-admin', \Bitaac\ThemeAdmin\ThemeAdminServiceProvider::class));

            if (file_exists($path = base_path('routes/extensions.php'))) {
                require_once $path;
            }

            $this->exceptions->handle(ModelNotFoundException::class, function ($e) {
                return new Response(view('errors.404'), 404);
            });

            $this->exceptions->handle(NotFoundHttpException::class, function ($e) {
                return new Response(view('errors.404'), 404);
            });
        });

        $this->app->register(HashServiceProvider::class);
        $this->app->register(LaravelServiceProvider::class);
        $this->app->register(CommunityServiceProvider::class);
        $this->app->register(AppServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(SHAHashServiceProvider::class);
        $this->app->register(PlayerServiceProvider::class);
        $this->app->register(AccountServiceProvider::class);
        $this->app->register(ForumServiceProvider::class);
        $this->app->register(HighscoreServiceProvider::class);
        $this->app->register(StoreServiceProvider::class);
        $this->app->register(GuildServiceProvider::class);
        $this->app->register(AdminServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);

        foreach ($this->bindingsAndAliases as $alias => $binding) {
            list($abstract, $concrete) = [key($binding), current($binding)];

            $this->app->bind($abstract, $concrete);
            $this->app->alias($abstract, $alias);
        }

        $this->app['config']->set('auth.providers.users.model', \Bitaac\Account\Models\Account::class);

        $this->app->singleton('Bitaac\Core\Bitaac', function ($app) {
            return new \Bitaac\Core\Bitaac();
        });

        $this->app->bind('bitaac', function () {
            return resolve(\Bitaac\Core\Bitaac::class);
        });

        $aliasloader->alias('Bitaac', \Bitaac\Core\Facades\Bitaac::class);

        $this->app->singleton('Bitaac\Core\Configurations\TwoFactorAuthConfiguration', function ($app) {
            return new \Bitaac\Core\Configurations\TwoFactorAuthConfiguration();
        });

        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator']);
        });

        foreach (config('bitaac.app.providers', []) as $provider) {
            $this->app->register($provider);
        }
    }
}
