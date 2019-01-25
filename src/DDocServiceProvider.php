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
        // 发布配置
        $configPath = dirname(__DIR__) . '/config/ddoc.php';
        if (function_exists('config_path')) {
            $configPublishPath = config_path('ddoc.php');
        } else {
            $configPublishPath = base_path('config/ddoc.php');
        }
        $this->publishes([$configPath => $configPublishPath], 'config');

        // 注册视图
        if ($this->app->has('view')) {
            $viewPath = dirname(__DIR__) . '/resources/views';
            $this->loadViewsFrom($viewPath, 'ddoc');
        }

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
        if (method_exists($this->app, 'configure')) {
            $this->app->configure('ddoc');
        }

        $this->mergeConfigFrom(dirname(__DIR__) . '/config/ddoc.php', 'ddoc');
    }
}
