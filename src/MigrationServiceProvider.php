<?php

namespace Sedehi\LaravelModule;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\MigrationServiceProvider as LaravelMigrationServiceProvider;
use Sedehi\LaravelModule\Commands\MakeMigration;

class MigrationServiceProvider extends LaravelMigrationServiceProvider
{
    protected function registerMigrateMakeCommand()
    {
        $abstractName = 'command.migrate.make';
        if(version_compare($this->app->version(),'9','>=')){
            $abstractName = MigrateMakeCommand::class;
        }
        $this->app->singleton($abstractName, function ($app) {
            $creator = $app['migration.creator'];
            $composer = $app['composer'];

            return new MakeMigration($creator, $composer);
        });
    }
}
