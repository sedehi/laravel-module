<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\ConsoleMakeCommand;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;

class MakeCommand extends ConsoleMakeCommand implements ModuleName
{
    use CommandOptions,Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {

        return $rootNamespace.$this->getModuleName().'\Commands';
    }
}
