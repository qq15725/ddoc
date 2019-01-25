<?php

namespace Wxm\DDoc\Controllers;

use App\Http\Controllers\Controller;
use Wxm\DDoc\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use ReflectionClass;


class DDocController extends Controller
{
    protected $router;

    /**
     * The blueprint instance.
     *
     * @var \Wxm\DDoc\Blueprint
     */
    protected $blueprint;

    public function __construct(Blueprint $blueprint)
    {
        if (!config('ddoc.enabled', false)) {
            abort(401);
        }
        $this->router    = app('router');
        $this->blueprint = $blueprint;
    }

    /**
     * 读取数据库信息
     */
    private function initTablesData()
    {
        $tables = DB::select('SHOW TABLE STATUS ');
        foreach ($tables as $key => $table) {
            $columns        = DB::select("SHOW FULL FIELDS FROM {$table->Name}");
            $table->columns = $columns;
            $tables[$key]   = $table;
        }
        return $tables;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ddoc::index');
    }

    public function readme()
    {
        return config('ddoc.readme');
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function apiDoc()
    {
        return $this->blueprint->generate(
            $this->getControllers(),
            '接口文档',
            $this->getVersion()
        );
    }

    public function databaseDoc()
    {
        $markdown = '';
        foreach ($this->initTablesData() as $key => $table) {
            $tableName = $table->Comment ? "{$table->Comment}（{$table->Name}）" : $table->Name;
            $markdown  .= "## {$tableName} \r\n";
            $markdown  .= "字段 | 类型 | 为空 | 键 | 默认值 | 特性 | 备注 \r\n";
            $markdown  .= "--- | --- | --- | -- | ----- | --- | --- \r\n";
            foreach ($table->columns as $column) {
                $markdown .= "{$column->Field} | {$column->Type} | {$column->Null} | {$column->Key} | {$column->Default} | {$column->Extra} | {$column->Comment} \r\n";
            }
            $markdown .= "\r\n";
        }
        return $markdown;
    }

    /**
     * Get the documentation version.
     *
     * @return string
     */
    protected function getVersion()
    {
        return 'v1';
    }

    /**
     *  Get all the controller instances.
     *
     * @return Collection
     *
     * @throws \ReflectionException
     */
    protected function getControllers()
    {
        $controllers = new Collection;
        foreach ($this->router->getRoutes() as $collections) {
            if (method_exists($collections, 'getAction')) {
                $action = $collections->getAction()['uses'];
            } elseif (isset($collections['action']) && isset($collections['action']['uses'])) {
                $action = $collections['action']['uses'];
            } else {
                continue;
            }
            if (is_string($action)) {
                list($controllerClass, $controllerMethod) = explode('@', $action);
                $this->addControllerIfNotExists($controllers, app($controllerClass));
            }
        }

        return $controllers;
    }

    /**
     * Add a controller to the collection if it does not exist. If the
     * controller implements an interface suffixed with "Docs" it
     * will be used instead of the controller.
     *
     * @param Collection $controllers
     * @param            $controller
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    protected function addControllerIfNotExists(Collection $controllers, $controller)
    {
        $class = get_class($controller);

        if ($controllers->has($class)) {
            return;
        }

        $reflection = new ReflectionClass($controller);

        $interface = Arr::first($reflection->getInterfaces(), function ($key, $value) {
            return ends_with($key, 'Docs');
        });

        if ($interface) {
            $controller = $interface;
        }

        $controllers->put($class, $controller);
    }
}