<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeRequestTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_make_a_new_request_class()
    {
        $this->artisan('make:request', [
            'name' => $this->sampleName,
        ]);

        $this->assertFileExists(app_path("Requests/{$this->sampleName}.php"));

        $this->artisan('make:request', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_make_a_request_class_type_option()
    {
        // admin type

        $this->artisan('make:request', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--admin' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Admin/{$this->sampleName}.php"));

        // site type
        $this->artisan('make:request', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--site' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Site/{$this->sampleName}.php"));

        // api type without version

        $this->artisan('make:request', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Api/{$this->sampleName}.php"));

        // api type with version
        $this->artisan('make:request', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api' => true,
            '--api-version' => 'v2',
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Api/V2/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_make_request_class_interactive()
    {
        $this->artisan('make:request', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('Create class for admin ?', 'y')
            ->expectsQuestion('Create class for site ?', 'y')
            ->expectsQuestion('Create class for api ?', 'y')
            ->expectsQuestion('What is the api version ?', 'v3')
            ->assertExitCode(0);

        $this->assertFileExists(
            app_path('Modules/'.$this->moduleName."/Requests/Admin/{$this->sampleName}.php")
        );
        $this->assertFileExists(
            app_path('Modules/'.$this->moduleName."/Requests/Site/{$this->sampleName}.php")
        );
        $this->assertFileExists(
            app_path('Modules/'.$this->moduleName."/Requests/Api/V3/{$this->sampleName}.php")
        );
    }
}
