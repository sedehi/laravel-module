<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\CastMakeCommand;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;
use Symfony\Component\Console\Input\InputOption;

class MakeCast extends CastMakeCommand implements ModuleName
{
    use CommandOptions,Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.$this->getModuleName().'\Casts';
    }

}
