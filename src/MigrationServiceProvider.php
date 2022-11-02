<?php

namespace Sedehi\LaravelModule;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\MigrationServiceProvider as LaravelMigrationServiceProvider;
use Sedehi\LaravelModule\Commands\MakeMigration;
use Sedehi\LaravelModule\Traits\AbstractName;

class MigrationServiceProvider extends LaravelMigrationServiceProvider
{
    use AbstractName;

    public function boot(){
        $this->loadMigration();
    }

    protected function registerMigrateMakeCommand()
    {
        $abstract = $this->abstractName('command.migrate.make', MigrateMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            $creator = $app['migration.creator'];
            $composer = $app['composer'];

            return new MakeMigration($creator, $composer);
        });
    }


    protected function loadMigration()
    {
        $migratePaths = glob(app_path('Modules/*/database/migrations'));
        $migratePaths = array_merge($migratePaths, [database_path('migrations')]);
        $this->loadMigrationsFrom($migratePaths);
    }
}
