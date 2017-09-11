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
        // 发布视图
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'ddoc');

        // 发布视图文件
        $this->publishes([
            dirname(__DIR__) . '/resources/views' => resource_path('views/vendor/ddoc'),
        ], 'views');

        // 发布配置文件
        $this->publishes([
            dirname(__DIR__) . '/config/ddoc.php' => config_path('ddoc.php'),
        ], 'config');

        // 发布资源文件
        $this->publishes([
            dirname(__DIR__) . '/assets' => public_path('vendor/ddoc')
        ], 'public');

        // 注册路由
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
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
