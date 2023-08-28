<?php

namespace Igorkalm\IDPcontroller;

use Illuminate\Support\ServiceProvider;

class IDPcontrollerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'idpcontroller');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'idpcontroller');
        
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/../config/idpcontroller.php' => config_path('IDPcontroller.php'),
            // ], 'config');
            $this->publishes([
                __DIR__.'/../config/idpcontroller.php' => config_path('idpcontroller.php')
            ]);

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/idpcontroller'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/idpcontroller'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/idpcontroller'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        // $this->mergeConfigFrom(__DIR__.'/../config/idpcontroller.php', 'idpcontroller');

        // Register the main class to use with the facade
        $this->app->singleton('idpcontroller', function () {
            return new IDPcontroller;
        });
    }
}
