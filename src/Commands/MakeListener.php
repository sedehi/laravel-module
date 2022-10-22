<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\ListenerMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\EventName;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;

class MakeListener extends ListenerMakeCommand implements ModuleName, EventName
{
    use CommandOptions,Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.$this->getModuleName().'\Listeners';
    }
}
