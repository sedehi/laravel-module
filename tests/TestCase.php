<?php

namespace Sedehi\LaravelModule\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sedehi\LaravelModule\LaravelModuleServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelModuleServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
