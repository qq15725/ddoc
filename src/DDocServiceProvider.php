<?php

namespace Wxm\DDoc;

use Illuminate\Support\ServiceProvider;

class DDocServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/config/ddoc.php' => function_exists('config_path')
                ? config_path('ddoc.php')
                : base_path('config/ddoc.php')
        ], 'config');
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'ddoc');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (method_exists($this->app, 'configure')) {
            $this->app->configure('ddoc');
        }
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/ddoc.php', 'ddoc');
    }
}
