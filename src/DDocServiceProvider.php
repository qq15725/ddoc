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
        // 发布视图文件
        $this->loadViewsFrom(__DIR__ . '/views', 'ddoc');

        // 发布配置文件
        $this->publishes([
            __DIR__ . '/../config/ddoc.php' => config_path('ddoc.php'),
            __DIR__ . '/../public/' => public_path('')
        ]);

        // 注册路由
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
