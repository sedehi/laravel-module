<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeTestTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_a_test()
    {
        $this->artisan('make:test', [
            'name' => $this->sampleName,
        ]);

        $this->assertFileExists(base_path("tests/Feature/{$this->sampleName}.php"));

        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Feature/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_a_test_with_unit_option()
    {
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--unit' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Unit/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_a_test_class_with_type_option()
    {
        // admin type
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--admin' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Admin/Feature/{$this->sampleName}.php"));

        // site type
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--site' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Site/Feature/{$this->sampleName}.php"));

        // api type without version
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Api/V1/Feature/{$this->sampleName}.php"));

        // api type with version
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api' => true,
            '--api-version' => 'v2',
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Api/V2/Feature/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function model_and_controller_is_required_if_module_and_crud_option_used()
    {
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--crud' => true,
        ])->expectsOutput('You should specify model name if using crud option')
            ->assertExitCode(0);

        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--crud' => true,
            '--model' => $this->sampleName,
        ])->expectsOutput('You should specify controller name if using crud option')
            ->assertExitCode(0);
    }

    /**
     * @return void
     * @test
     */
    public function interactive_without_module()
    {
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', null)
            ->expectsQuestion('Do you want to create a unit test class ?', 'yes')
            ->assertExitCode(0);

        $this->assertFileExists(base_path("tests/Unit/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function interactive_with_module_and_crud()
    {
        $this->artisan('make:test', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('Do you want to create a unit test class ?', 'yes')
            ->expectsQuestion('Do you want to create a crud test ?', 'yes')
            ->expectsQuestion('Enter controller name', $this->sampleName)
            ->expectsQuestion('Enter model name', $this->sampleName)
            ->expectsQuestion('What part this class belongs to ?', 'admin')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/tests/Admin/Unit/{$this->sampleName}.php"));
    }
}
