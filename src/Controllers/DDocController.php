<?php
namespace Wxm\DDoc\Controllers;
use App\Http\Controllers\Controller;
use Dingo\Blueprint\Blueprint;
use Illuminate\Http\Request;
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
        $tables = DB::select('SHOW TABLE STATUS ');
        foreach ($tables as $key => $table) {
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
    public function index(Request $request)
    {
        return view('ddoc::index');
    }

    public function login(Request $request)
    {
        $request->session()->put('ddoc_password', $request->input('password'));
        return redirect('/ddoc');
    }

    public function readme()
    {
        if (!$this->auth()) {
            return '请登录';
        }

        return config('ddoc.readme');
    }

    public function apiDoc()
    {
        if (!$this->auth()) {
            return '请登录';
        }

        return $this->blueprint->generate(
            $this->getControllers(),
            $this->getDocName(),
            $this->getVersion()
        );
    }

    public function databaseDoc()
    {
        if (!$this->auth()) {
            return '请登录';
        }

        $title = config('app.name', '') . ' 数据字典';

        $markdown = "## {$title} \r\n";
        foreach($this->initTablesData() as $key => $table) {
            $markdown .= "## {$table->Comment} {$table->Name} \r\n";
            $markdown .= "字段 | 类型 | 为空 | 键 | 默认值 | 特性 | 备注 \r\n";
            $markdown .= "--- | --- | --- | -- | ----- | --- | --- \r\n";
            foreach($table->columns as $column) {
                $markdown .= "{$column->Field} | {$column->Type} | {$column->Null} | {$column->Key} | {$column->Default} | {$column->Extra} | {$column->Comment} \r\n";
            }
        }
        return $markdown;
    }

    protected function auth()
    {
        if (config('ddoc.auth.enable', true)) {
            return session()->get('ddoc_password') == config('ddoc.auth.password', 'root');
        }
        return true;
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