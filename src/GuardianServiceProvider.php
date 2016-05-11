<?php

namespace EmilMoe\Guardian;

use Illuminate\Support\ServiceProvider;
use EmilMoe\Guardian\Http\Middleware\GuardianMiddleware;

class GuardianServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ .'/config/guardian.php' => config_path('guardian.php'),
            'config']);

        $this->publishes([
            __DIR__ .'/database/migrations/' => database_path('migrations'),
            'migrations']);

        $this->mergeConfigFrom(__DIR__ .'/config/guardian.php', 'guardian');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $router = $this->app['router'];
        $router->middleware('guard', GuardianMiddleware::class);

        if (config('guardian.api.enabled'))
            $router->group([
                'namespace'  => 'EmilMoe\Guardian\Http\Controllers',
                'prefix'     => config('guardian.api.url'),
                'middleware' => 'auth'
            ], function () {
                require __DIR__ .'/Http/routes.php';
            });
    }
}