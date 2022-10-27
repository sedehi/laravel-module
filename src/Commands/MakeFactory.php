<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModelName;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;

class MakeFactory extends FactoryMakeCommand implements ModuleName, ModelName
{
    use CommandOptions,Interactive;

    protected function getPath($name)
    {
        $name = str_replace(['\\', '/'], '', $this->argument('name'));
        if ($this->option('module') !== null) {
            return app_path('Modules/'.Str::studly($this->option('module'))."/database/factories/{$name}.php");
        }

        return $this->laravel->databasePath()."/factories/{$name}.php";
    }
}
