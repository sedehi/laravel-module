<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeResourceTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_a_resource_class()
    {
        $this->artisan('make:resource', [
            'name' => $this->sampleName,
        ]);

        $this->assertFileExists(app_path("Resources/{$this->sampleName}.php"));

        $this->artisan('make:resource', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Resources/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_a_resource_class_with_api_version_option()
    {
        $this->artisan('make:resource', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api-version' => 'v2',
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Resources/V2/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_a_resource_class_interactive()
    {
        $this->artisan('make:resource', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('What is the api version ?', 'v3')
            ->expectsQuestion('Do you want to make a resource collection class ?', 'yes')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Resources/V3/{$this->sampleName}.php"));
    }
}
