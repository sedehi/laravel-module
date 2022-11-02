<?php

namespace Sedehi\LaravelModule;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Foundation\Console\CastMakeCommand;
use Illuminate\Foundation\Console\ChannelMakeCommand;
use Illuminate\Foundation\Console\ConsoleMakeCommand;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Foundation\Console\ExceptionMakeCommand;
use Illuminate\Foundation\Console\JobMakeCommand;
use Illuminate\Foundation\Console\ListenerMakeCommand;
use Illuminate\Foundation\Console\MailMakeCommand;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Foundation\Console\ObserverMakeCommand;
use Illuminate\Foundation\Console\PolicyMakeCommand;
use Illuminate\Foundation\Console\RequestMakeCommand;
use Illuminate\Foundation\Console\ResourceMakeCommand;
use Illuminate\Foundation\Console\RuleMakeCommand;
use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Illuminate\Routing\Console\ControllerMakeCommand;
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

class CommandsServiceProvider extends ArtisanServiceProvider
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

        $this->app->register(MigrationServiceProvider::class);

        parent::register();
    }

    protected function registerModelMakeCommand()
    {
        $abstract = $this->abstractName('command.model.make', ModelMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeModel($app['files']);
        });
    }

    protected function registerFactoryMakeCommand()
    {
        $abstract = $this->abstractName('command.factory.make', FactoryMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeFactory($app['files']);
        });
    }

    protected function registerEventMakeCommand()
    {
        $abstract = $this->abstractName('command.event.make', EventMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeEvent($app['files']);
        });
    }

    protected function registerListenerMakeCommand()
    {
        $abstract = $this->abstractName('command.listener.make', ListenerMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeListener($app['files']);
        });
    }

    protected function registerChannelMakeCommand()
    {
        $abstract = $this->abstractName('command.channel.make', ChannelMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeChannel($app['files']);
        });
    }

    protected function registerConsoleMakeCommand()
    {
        $abstract = $this->abstractName('command.console.make', ConsoleMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeCommand($app['files']);
        });
    }

    protected function registerJobMakeCommand()
    {
        $abstract = $this->abstractName('command.job.make', JobMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeJob($app['files']);
        });
    }

    protected function registerMailMakeCommand()
    {
        $abstract = $this->abstractName('command.mail.make', MailMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeMail($app['files']);
        });
    }

    protected function registerNotificationMakeCommand()
    {
        $abstract = $this->abstractName('command.notification.make', NotificationMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeNotification($app['files']);
        });
    }

    protected function registerObserverMakeCommand()
    {
        $abstract = $this->abstractName('command.observer.make', ObserverMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeObserver($app['files']);
        });
    }

    protected function registerPolicyMakeCommand()
    {
        $abstract = $this->abstractName('command.policy.make', PolicyMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakePolicy($app['files']);
        });
    }

    protected function registerCastMakeCommand()
    {
        $abstract = $this->abstractName('command.cast.make', CastMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeCast($app['files']);
        });
    }

    protected function registerExceptionMakeCommand()
    {
        $abstract = $this->abstractName('command.exception.make', ExceptionMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeException($app['files']);
        });
    }

    protected function registerRuleMakeCommand()
    {
        $abstract = $this->abstractName('command.rule.make', RuleMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeRule($app['files']);
        });
    }

    protected function registerSeederMakeCommand()
    {
        $abstract = $this->abstractName('command.seeder.make', SeederMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeSeeder($app['files']);
        });
    }

    protected function registerRequestMakeCommand()
    {
        $abstract = $this->abstractName('command.request.make', RequestMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeRequest($app['files']);
        });
    }

    protected function registerResourceMakeCommand()
    {
        $abstract = $this->abstractName('command.resource.make', ResourceMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeResource($app['files']);
        });
    }

    protected function registerControllerMakeCommand()
    {
        $abstract = $this->abstractName('command.controller.make', ControllerMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeController($app['files']);
        });
    }

    protected function registerTestMakeCommand()
    {
        $abstract = $this->abstractName('command.test.make', TestMakeCommand::class);
        $this->app->singleton($abstract, function ($app) {
            return new MakeTest($app['files']);
        });
    }

    protected function registerModuleMakeCommand()
    {
        $this->app->singleton(MakeModule::class, function () {
            return new MakeModule();
        });
    }

    protected function registerCrudMakeCommand()
    {
        $this->app->singleton(MakeCrud::class, function () {
            return new MakeCrud();
        });
    }

    protected function registerViewMakeCommand()
    {
        $this->app->singleton(MakeView::class, function () {
            return new MakeView();
        });
    }
}
