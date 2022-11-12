<?php

namespace Sedehi\LaravelModule;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaravelModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViews();
        $this->viewComposers();
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->app->register(CommandsServiceProvider::class);
        }
    }

    /**
     * @return void
     */
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
            $module = $str->first();
            $controllerWithMethod = explode('@', $str->last());
            $controller = head($controllerWithMethod);
            $method = end($controllerWithMethod);
            if ($controller == $method) {
                $method = '';
            }

            return $view->with('module', $module)->with('controller', $controller)->with('method', $method);
        });
    }
}
