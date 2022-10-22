<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\ResourceMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ApiVersion;
use Sedehi\LaravelModule\Commands\Questions\ResourceCollection;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\Interactive;
use Symfony\Component\Console\Input\InputOption;

class MakeResource extends ResourceMakeCommand implements ModuleName, ApiVersion, ResourceCollection
{
    use Interactive;

    protected function getOptions()
    {
        $options = parent::getOptions();
        $options = array_merge($options, [
            ['section', null, InputOption::VALUE_OPTIONAL, 'The name of the section'],
            ['in', false, InputOption::VALUE_NONE, 'Interactive mode'],
            ['api-version', 'av', InputOption::VALUE_OPTIONAL, 'Set api version'],
        ]);

        return $options;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace.'\Http';
        if ($this->option('module') !== null) {
            $namespace .= '\Controllers\\'.Str::studly($this->option('module'));
        }
        if ($this->option('api-version') !== null) {
            return $namespace.'\Resources\\'.Str::studly($this->option('api-version'));
        }

        return $namespace.'\Resources';
    }
}
