<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;

class MakeNotification extends NotificationMakeCommand implements ModuleName
{
    use CommandOptions,Interactive;

    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace.'\Http';
        if ($this->option('module') !== null) {
            $namespace .= '\Controllers\\'.Str::studly($this->option('module'));
        }

        return $namespace.'\Notifications';
    }
}
