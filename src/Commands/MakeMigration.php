<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\Interactive;

class MakeMigration extends MigrateMakeCommand implements ModuleName
{
    use Interactive;

    public function __construct($creator, $composer)
    {
        $this->signature .= '{--module= : The name of the section}';
        $this->signature .= '{--in=false : Interactive mode}';
        parent::__construct($creator, $composer);
    }

    protected function getMigrationPath()
    {
        $module = (Str::studly($this->input->getOption('module')));
        if ($module !== '') {
            $path = $this->laravel->basePath().'/app/'.$module.'/database/migrations';
            $this->makeDirectory($path);

            return $path;
        }
        if (($targetPath = $this->input->getOption('path')) !== null) {
            return ! $this->usingRealPath() ? $this->laravel->basePath().'/'.$targetPath : $targetPath;
        }

        return parent::getMigrationPath();
    }

    protected function makeDirectory($path)
    {
        if (! app('files')->isDirectory($path)) {
            app('files')->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
