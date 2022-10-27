<?php

namespace Sedehi\LaravelModule\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;
use Sedehi\LaravelModule\LaravelModuleServiceProvider;

class TestCase extends Orchestra
{
    public $moduleName = 'TestModule';
    public $sampleName = 'FakeName';
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

    public function tearDown(): void
    {
        File::deleteDirectory(app_path('Modules/'.$this->moduleName));
    }
}
