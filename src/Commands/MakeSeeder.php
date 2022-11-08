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

    protected function getPath($name)
    {
        if ($this->option('module') == null) {
            return parent::getPath($name);
        }

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return app_path('Modules/'.$this->option('module').'/database/seeders/'.$name.'.php');
    }

    protected function rootNamespace()
    {
        if ($this->option('module') == null) {
            return parent::rootNamespace();
        }

        return 'App\Modules\\'.Str::studly($this->option('module')).'\database\seeders\\';
    }
}
