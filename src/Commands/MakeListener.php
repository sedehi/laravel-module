<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\ListenerMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\EventName;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;

class MakeListener extends ListenerMakeCommand implements ModuleName, EventName
{
    use CommandOptions,Interactive;

    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace.'\Http';
        if ($this->option('module') !== null) {
            $namespace .= '\Controllers\\'.Str::studly($this->option('module'));
        }

        return $namespace.'\Listeners';
    }
}
