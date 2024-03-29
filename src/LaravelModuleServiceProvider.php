<?php

namespace Sedehi\LaravelModule;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaravelModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViews();
        $this->viewComposers();
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/module.php' => config_path('module.php'),
            ], 'module-config');
        }
        $this->registerDirective();
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->app->register(CommandsServiceProvider::class);
        }

        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'module');
    }

    private function loadViews(): void
    {
        view()->addLocation(app_path('Modules'));
        foreach (glob(app_path('Modules/*/views')) as $modulePath) {
            $module = explode('/', $modulePath);
            $module = $module[count($module) - 2];
            view()->addNamespace($module, app_path('Modules/'.$module.'/views'));
        }
    }

    private function viewComposers()
    {
        view()->composer(['*::admin.*.*', 'crud.index', 'crud.show', 'crud.create', 'crud.edit'], function ($view) {
            $str = Str::of(request()->route()->getActionName())->after('App\Modules\\')->explode('\\');
            $routePrefix = null;
            $routePrefixSingular = null;
            $routeName = request()->route()->getName();
            $routeNames = explode('.', $routeName);
            if (count($routeNames) >= 3) {
                unset($routeNames[array_key_last($routeNames)]);
                unset($routeNames[0]);
                $routePrefix = implode('.', $routeNames);
                $routePrefixSingular = Str::singular($routePrefix);
            }
            $module = $str->first();
            $controllerWithMethod = explode('@', $str->last());
            $controller = head($controllerWithMethod);
            $method = end($controllerWithMethod);
            if ($controller == $method) {
                $method = '';
            }

            return $view->with('module', $module)
                ->with('controller', $controller)
                ->with('method', $method)
                ->with('routeName', $routeName)
                ->with('routePrefix', $routePrefix)
                ->with('routePrefixSingular', $routePrefixSingular);
        });
    }

    protected function registerDirective()
    {
        Blade::if('hasRoute', function ($expression) {
            return "<?php auth(config('module.admin_guard'))->user()->hasRoute($expression) ?>";
        });
    }
}
