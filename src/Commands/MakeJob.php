<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\JobMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;

class MakeJob extends JobMakeCommand implements ModuleName
{
    use CommandOptions,Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.$this->getModuleName().'\Jobs';
    }
}
