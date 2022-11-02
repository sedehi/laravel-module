<?php

namespace Sedehi\LaravelModule;

use Illuminate\Support\ServiceProvider;


class LaravelModuleServiceProvider extends ServiceProvider
{

    public function boot(){
        view()->addLocation(app_path('Modules'));
        foreach (glob(app_path('Modules/*/views')) as $modulePath){
            $module = explode('/',$modulePath);
            $module = $module[count($module)-2];
            view()->addNamespace($module,app_path('Modules/'.$module.'/views'));
        }
    }

    public function register()
    {
        if($this->app->runningInConsole()){
            $this->app->register(CommandsServiceProvider::class);
        }
    }
}
