<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\CommandOptions;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;

class MakeNotification extends NotificationMakeCommand implements ModuleName
{
    use CommandOptions,Interactive,ModuleNameOption;

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.$this->getModuleName().'\Notifications';
    }
}
