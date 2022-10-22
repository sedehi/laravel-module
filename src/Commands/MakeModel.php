<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;

class MakeModel extends ModelMakeCommand implements ModuleName
{
    use CommandOptions,Interactive;

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('module') !== null) {
            return $rootNamespace.'\Http\Controllers\\'.Str::studly($this->option('module')).'\\Models';
        }

        return $rootNamespace;
    }

    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));
        $this->call('make:factory', [
            'name'      => "{$factory}Factory",
            '--model'   => $this->qualifyClass($this->getNameInput()),
            '--section' => Str::studly($this->option('module')),
        ]);
    }

    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));
        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }
        $this->call('make:migration', [
            'name'      => "create_{$table}_table",
            '--create'  => $table,
            '--section' => Str::studly($this->option('module')),
        ]);
    }
}
