<?php

namespace Acacha\Forge\Providers;

use Acacha\Forge\Events\ServerHasBeenAssignedToUser;
use Acacha\Forge\Events\ServerRequestPermissionHasBeenAsked;
use Acacha\Forge\Listeners\SendNotificationServerHasBeenAssignedToUserToManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Themsaid\Forge\Forge;

/**
 * Class AcachaForgeServiceProvider.
 */
class AcachaForgeServiceProvider extends ServiceProvider
{

    const NAMESPACE = 'Acacha\Forge\Http\Controllers';

    public function register()
    {
        if (!defined('ACACHA_FORGE_PATH')) {
            define('ACACHA_FORGE_PATH', realpath(__DIR__.'/../../'));
        }

        $this->registerEloquentFactoriesFrom(ACACHA_FORGE_PATH . '/database/factories');

        $this->registerAcachaForgeServices();

        $this->mergeConfigFrom(
            ACACHA_FORGE_PATH.'/config/forge.php', 'forge'
        );
    }

    /**
     * Register Acacha forge services
     */
    protected function registerAcachaForgeServices()
    {
        $this->app->singleton(Forge::class, function () {
            return new Forge(env('FORGE_API_TOKEN'));
        });

    }

    /**
     * Boot
     */
    public function boot()
    {
        $this->defineRoutes();
        $this->loadViews();
        $this->loadmigrations();
        $this->registerEventListeners();

        $this->publishConfig();
    }

    /**
     * Define routes.
     */
    private function defineRoutes()
    {
        $this->defineWebRoutes();
        $this->defineApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    private function defineWebRoutes() {
        $this->app->make('router')->middleware('web')
            ->namespace(AcachaForgeServiceProvider::NAMESPACE)
            ->group(ACACHA_FORGE_PATH .'/routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function defineApiRoutes()
    {
        $this->app->make('router')->prefix('api')->middleware('api')
            ->namespace(AcachaForgeServiceProvider::NAMESPACE)
            ->group(ACACHA_FORGE_PATH .'/routes/api.php');
    }

    /**
     * Load views
     */
    private function loadViews()
    {
        $this->loadViewsFrom(ACACHA_FORGE_PATH.'/resources/views', 'acacha-forge');
    }

    /**
     * Load migrations.
     */
    private function loadMigrations()
    {
        $this->loadMigrationsFrom(ACACHA_FORGE_PATH.'/database/migrations');
    }

    private function registerEventListeners() {
        $this->app->make('events')->listen(
            ServerRequestPermissionHasBeenAsked::class,
            SendNotificationServerHasBeenAssignedToUserToManager::class
        );

        $this->app->make('events')->listen(
            ServerHasBeenAssignedToUser::class,
            SendNotificationServerHasBeenAssignedToUserToManager::class
        );
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

    /**
     * Publish config.
     */
    protected function publishConfig()
    {
        $this->publishes([
            ACACHA_FORGE_PATH .'/config/forge.php' => config_path('forge.php'),
        ]);
    }
}