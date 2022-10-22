<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\ObserverMakeCommand;
use Sedehi\LaravelModule\Commands\Questions\ModelName;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;

class MakeObserver extends ObserverMakeCommand implements ModuleName, ModelName
{
    use CommandOptions,Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.$this->getModuleName().'\Observers';
    }
}
