<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeControllerTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_controller()
    {
        $this->artisan('make:controller', [
            'name' => $this->sampleName,
        ]);

        $this->assertFileExists(app_path("Http/Controllers/{$this->sampleName}.php"));

        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\{$this->sampleName}Request";
        $requestClassPath = app_path('Modules/'.$this->moduleName."/Requests/{$this->sampleName}Request.php");

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ])->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'yes')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/{$this->sampleName}.php"));
        $this->assertFileExists($requestClassPath);
    }

    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_controller_class_type_option()
    {
        // admin type
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\Admin\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--admin' => true,
        ])->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Admin/{$this->sampleName}.php"));

        // site type

        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\Site\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--site' => true,
        ])->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Site/{$this->sampleName}.php"));

        // api type without version
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\Api\\V1\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api' => true,
        ])->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Api/{$this->sampleName}.php"));

        // api type with version
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\Api\\V2\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--api' => true,
            '--api-version' => 'v2',
        ])->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Api/V2/{$this->sampleName}.php"));
    }

    /**
     * @return void
     *
     * @test
     */
    public function model_is_required_if_crud_option_used()
    {
        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
            '--crud' => true,
        ])->expectsOutput('You should specify model when using crud option')
            ->assertExitCode(0);
    }

    /**
     * @return void
     *
     * @test
     */
    public function interactive_controller_types()
    {
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('What type of controller do you want ?', 'invokable')
            ->expectsQuestion('What part this class belongs to ?', 'none')
            ->expectsQuestion('Show additional options for controller ?', 'yes')
            ->expectsQuestion('Do you want to force create the controller class ?', 'yes')
            ->expectsQuestion('Do you want to add custom views option for controller class ?', 'yes')
            ->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);
    }

    /**
     * @return void
     *
     * @test
     */
    public function interactive_resource_controller_should_aks_for_parent_model_name()
    {
        $modelClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Models\\{$this->sampleName}";
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('What type of controller do you want ?', 'resource')
            ->expectsQuestion('Add parent model to resource controller ?', 'yes')
            ->expectsQuestion('Enter parent model name:', $this->sampleName)
            ->expectsQuestion('What part this class belongs to ?', 'none')
            ->expectsQuestion('Show additional options for controller ?', false)
            ->expectsQuestion("A {$modelClass} model does not exist. Do you want to generate it?", 'no')
            ->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);
    }

    /**
     * @return void
     *
     * @test
     */
    public function interactive_crud_controller_should_aks_for_model_name()
    {
        $modelClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Models\\{$this->sampleName}";
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('What type of controller do you want ?', 'crud')
            ->expectsQuestion('Enter model name', $this->sampleName)
            ->expectsQuestion('What part this class belongs to ?', 'none')
            ->expectsQuestion('Show additional options for controller ?', false)
            ->expectsQuestion("A {$modelClass} model does not exist. Do you want to generate it?", 'no')
            ->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);
    }

    /**
     * @return void
     *
     * @test
     */
    public function interactive_upload_controller_should_aks_for_model_name()
    {
        $modelClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Models\\{$this->sampleName}";
        $requestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\\{$this->sampleName}Request";

        $this->artisan('make:controller', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('What type of controller do you want ?', 'upload')
            ->expectsQuestion('Enter model name', $this->sampleName)
            ->expectsQuestion('What part this class belongs to ?', 'none')
            ->expectsQuestion('Show additional options for controller ?', false)
            ->expectsQuestion("A {$modelClass} model does not exist. Do you want to generate it?", 'no')
            ->expectsQuestion("A {$requestClass} Request does not exist. Do you want to generate it?", 'no')
            ->assertExitCode(0);
    }
}
