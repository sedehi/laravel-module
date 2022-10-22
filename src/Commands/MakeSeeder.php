<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;

class MakeSeeder extends SeederMakeCommand implements ModuleName
{
    use CommandOptions,Interactive;

    protected function qualifyClass($name)
    {
        if ($this->option('module') == null) {
            return parent::qualifyClass($name);
        }

        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }

    protected function getPath($name)
    {
        if ($this->option('module') == null) {
            return parent::getPath($name);
        }

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace.'\Http';
        if ($this->option('module') !== null) {
            $namespace .= '\Controllers\\'.Str::studly($this->option('module'));
        }

        return $namespace.'\database\seeds';
    }

    protected function getStub()
    {
        if ($this->option('module') == null) {
            return parent::getStub();
        }

        return __DIR__.'/stubs/seeder.stub';
    }
}
