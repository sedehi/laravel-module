<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\JobMakeCommand;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;
use Symfony\Component\Console\Input\InputOption;

class MakeJob extends JobMakeCommand implements ModuleName
{
    use Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {
        $rootNamespace = $rootNamespace.$this->getModuleName();
        if($this->option('action')){
            return $rootNamespace.'\Actions';
        }
        return $rootNamespace.'\Jobs';
    }


    protected function getOptions()
    {
        $options = parent::getOptions();
        $options = array_merge($options, [
            ['action', 'aa', InputOption::VALUE_NONE, 'Generate as an action'],
            ['module', null, InputOption::VALUE_OPTIONAL, 'The name of the module'],
            ['in', false, InputOption::VALUE_NONE, 'Interactive mode'],
        ]);

        return $options;
    }
}
