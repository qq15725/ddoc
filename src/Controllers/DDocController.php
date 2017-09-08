<?php
namespace Wxm\DDoc\Controllers;
use App\Http\Controllers\Controller;
use Dingo\Blueprint\Blueprint;
use Illuminate\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use ReflectionClass;


class DDocController extends Controller
{

    protected $router;

    /**
     * Router instance.
     *
     * @var null || \Dingo\Api\Routing\Router
     */
    protected $dinGoRouter = null;

    /**
     * The blueprint instance.
     *
     * @var \Dingo\Blueprint\Blueprint
     */
    protected $blueprint;

    public function __construct(Router $router, Blueprint $blueprint)
    {
        $this->router = $router;

        $this->blueprint = $blueprint;

        if (class_exists('\Dingo\Api\Routing\Router')) {
            $this->dinGoRouter = app(\Dingo\Api\Routing\Router::class);
        }
    }

    /**
     * 读取数据库信息
     */
    private function initTablesData()
    {
        //获取数据库表名称列表
        $tables = DB::select('SHOW TABLE STATUS ');
        foreach ($tables as $key => $table) {
            //获取改表的所有字段信息
            $columns = DB::select("SHOW FULL FIELDS FROM {$table->Name}");
            $table->columns = $columns;
            $tables[$key] = $table;
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
        $tables = $this->initTablesData();

        $apiDoc = $this->blueprint->generate($this->getControllers(), $this->getDocName(), $this->getVersion());

        return view('ddoc::index', compact('tables', 'apiDoc'));
    }

    /**
     * Get the documentation name.
     *
     * @return string
     */
    protected function getDocName()
    {
        return config('app.name', '') . ' 接口文档';
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
     * Get all the controller instances.
     *
     * @return array
     */
    protected function getControllers()
    {
        $controllers = new Collection;

        foreach ($this->router->getRoutes() as $collections) {
            $action = $collections->action['uses'];
            if (is_string($action)) {
                list($controllerClass, $controllerMethod) = explode('@', $action);
                $this->addControllerIfNotExists($controllers, app($controllerClass));
            }
        }

        if (!is_null($this->dinGoRouter)) {
            foreach ($this->dinGoRouter->getRoutes() as $collections) {
                foreach ($collections as $route) {
                    if ($controller = $route->getControllerInstance()) {
                        $this->addControllerIfNotExists($controllers, $controller);
                    }
                }
            }
        }

        return $controllers;
    }

    /**
     * Add a controller to the collection if it does not exist. If the
     * controller implements an interface suffixed with "Docs" it
     * will be used instead of the controller.
     *
     * @param \Illuminate\Support\Collection $controllers
     * @param object                         $controller
     *
     * @return void
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