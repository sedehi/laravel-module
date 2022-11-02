<?php

namespace Sedehi\LaravelModule;

use Illuminate\Support\ServiceProvider;


class LaravelModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        if($this->app->runningInConsole()){
            $this->app->register(CommandsServiceProvider::class);
        }
    }
}
