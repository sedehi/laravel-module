<?php

namespace Sedehi\LaravelModule;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\MigrationServiceProvider as LaravelMigrationServiceProvider;
use Sedehi\LaravelModule\Commands\MakeMigration;
use Sedehi\LaravelModule\Traits\AbstractName;

class MigrationServiceProvider extends LaravelMigrationServiceProvider
{
    use AbstractName;
    protected function registerMigrateMakeCommand()
    {
        $abstract = $this->abstractName('command.migrate.make',MigrateMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            $creator = $app['migration.creator'];
            $composer = $app['composer'];

            return new MakeMigration($creator, $composer);
        });
    }
}
