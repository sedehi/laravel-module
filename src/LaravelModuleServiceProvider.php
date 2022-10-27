<?php

namespace Sedehi\LaravelModule;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Foundation\Console\CastMakeCommand;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Sedehi\LaravelModule\Commands\MakeCast;
use Sedehi\LaravelModule\Commands\MakeChannel;
use Sedehi\LaravelModule\Commands\MakeCommand;
use Sedehi\LaravelModule\Commands\MakeController;
use Sedehi\LaravelModule\Commands\MakeCrud;
use Sedehi\LaravelModule\Commands\MakeEvent;
use Sedehi\LaravelModule\Commands\MakeException;
use Sedehi\LaravelModule\Commands\MakeFactory;
use Sedehi\LaravelModule\Commands\MakeJob;
use Sedehi\LaravelModule\Commands\MakeListener;
use Sedehi\LaravelModule\Commands\MakeMail;
use Sedehi\LaravelModule\Commands\MakeModel;
use Sedehi\LaravelModule\Commands\MakeModule;
use Sedehi\LaravelModule\Commands\MakeNotification;
use Sedehi\LaravelModule\Commands\MakeObserver;
use Sedehi\LaravelModule\Commands\MakePolicy;
use Sedehi\LaravelModule\Commands\MakeRequest;
use Sedehi\LaravelModule\Commands\MakeResource;
use Sedehi\LaravelModule\Commands\MakeRule;
use Sedehi\LaravelModule\Commands\MakeSeeder;
use Sedehi\LaravelModule\Commands\MakeTest;
use Sedehi\LaravelModule\Commands\MakeView;
use Sedehi\LaravelModule\Traits\AbstractName;

class LaravelModuleServiceProvider extends ArtisanServiceProvider
{
    use AbstractName;

    public function register()
    {
        $this->devCommands = array_merge(
            $this->devCommands,
            [
                'ModuleMake' => MakeModule::class,
                'CrudMake' => MakeCrud::class,
                'ViewMake' => MakeView::class,
            ]
        );


        if (class_exists(\Illuminate\Database\MigrationServiceProvider::class)) {
            $this->app->register(MigrationServiceProvider::class);
        }

        parent::register();
    }

    protected function registerModelMakeCommand()
    {
        $abstract = $this->abstractName('command.model.make',ModelMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeModel($app['files']);
        });
    }

    protected function registerFactoryMakeCommand()
    {
        $abstract = $this->abstractName('command.factory.make',FactoryMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeFactory($app['files']);
        });
    }

    protected function registerEventMakeCommand()
    {
        $abstract = $this->abstractName('command.event.make',EventMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeEvent($app['files']);
        });
    }

    protected function registerListenerMakeCommand()
    {
        $this->app->singleton('command.listener.make', function ($app) {
            return new MakeListener($app['files']);
        });
    }

    protected function registerChannelMakeCommand()
    {
        $this->app->singleton('command.channel.make', function ($app) {
            return new MakeChannel($app['files']);
        });
    }

    protected function registerConsoleMakeCommand()
    {
        $this->app->singleton('command.console.make', function ($app) {
            return new MakeCommand($app['files']);
        });
    }

    protected function registerJobMakeCommand()
    {
        $this->app->singleton('command.job.make', function ($app) {
            return new MakeJob($app['files']);
        });
    }

    protected function registerMailMakeCommand()
    {
        $this->app->singleton('command.mail.make', function ($app) {
            return new MakeMail($app['files']);
        });
    }

    protected function registerNotificationMakeCommand()
    {
        $this->app->singleton('command.notification.make', function ($app) {
            return new MakeNotification($app['files']);
        });
    }

    protected function registerObserverMakeCommand()
    {
        $this->app->singleton('command.observer.make', function ($app) {
            return new MakeObserver($app['files']);
        });
    }

    protected function registerPolicyMakeCommand()
    {
        $this->app->singleton('command.policy.make', function ($app) {
            return new MakePolicy($app['files']);
        });
    }

    protected function registerCastMakeCommand()
    {
        $abstract = $this->abstractName('command.event.make',CastMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeCast($app['files']);
        });
    }

    protected function registerExceptionMakeCommand()
    {
        $this->app->singleton('command.exception.make', function ($app) {
            return new MakeException($app['files']);
        });
    }

    protected function registerRuleMakeCommand()
    {
        $this->app->singleton('command.rule.make', function ($app) {
            return new MakeRule($app['files']);
        });
    }

    protected function registerSeederMakeCommand()
    {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new MakeSeeder($app['files'], $app['composer']);
        });
    }

    protected function registerRequestMakeCommand()
    {
        $this->app->singleton('command.request.make', function ($app) {
            return new MakeRequest($app['files']);
        });
    }

    protected function registerResourceMakeCommand()
    {
        $this->app->singleton('command.resource.make', function ($app) {
            return new MakeResource($app['files']);
        });
    }

    protected function registerControllerMakeCommand()
    {
        $this->app->singleton('command.controller.make', function ($app) {
            return new MakeController($app['files']);
        });
    }

    protected function registerTestMakeCommand()
    {
        $this->app->singleton('command.test.make', function ($app) {
            return new MakeTest($app['files']);
        });
    }

    protected function registerModuleMakeCommand()
    {
        $this->app->singleton('command.module.make', function ($app) {
            return new MakeModule($app['files']);
        });
    }

    protected function registerCrudMakeCommand()
    {
        $this->app->singleton('command.crud.make', function ($app) {
            return new MakeCrud($app['files']);
        });
    }

    protected function registerViewMakeCommand()
    {
        $this->app->singleton('command.viewmake', function ($app) {
            return new MakeView($app['files']);
        });
    }
}
