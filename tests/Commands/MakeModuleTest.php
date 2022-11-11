<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeModuleTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_module_with_crud()
    {
        $this->sampleName = 'Testmodule';
        $moduleName = $this->moduleName;
        $this->moduleName = 'Testmodule';
        $adminRequestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\Admin\\{$this->sampleName}Request";
        $siteRequestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\Site\\{$this->sampleName}Request";
        $apiRequestClass = app()->getNamespace().'Modules\\'.$this->moduleName."\\Requests\Api\V1\\{$this->sampleName}Request";

        $this->artisan('make:module', [
            'name' => $moduleName,
        ])->expectsQuestion('Do you want to create model ?', 'yes')
            ->expectsQuestion('Do you want to create admin controller ?', 'yes')
            ->expectsQuestion('Do you want to upload picture in admin ?', 'yes')
            ->expectsQuestion("A {$adminRequestClass} Request does not exist. Do you want to generate it?", 'yes')
            ->expectsQuestion('Do you want to create site controller ?', 'yes')
            ->expectsQuestion("A {$siteRequestClass} Request does not exist. Do you want to generate it?", 'yes')
            ->expectsQuestion('Do you want to create api controller ?', 'yes')
            ->expectsQuestion("A {$apiRequestClass} Request does not exist. Do you want to generate it?", 'yes')
            ->expectsQuestion('Do you want to create factory ?', 'yes')
            ->expectsQuestion('Do you want to create migration ?', 'yes')
            ->expectsQuestion('What is table name?', 'test')
            ->expectsQuestion('Do you want to create route ?', 'yes')
            ->assertExitCode(0);

        $lowerSampleName = strtolower($this->sampleName);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Models/{$this->sampleName}.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Admin/{$this->sampleName}Controller.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Api/V1/{$this->sampleName}Controller.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Controllers/Site/{$this->sampleName}Controller.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/database/factories/{$this->sampleName}Factory.php"));
        $this->assertCount(1, glob(app_path('Modules/'.$this->moduleName.'/database/migrations/*_create_test_table.php')));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Admin/{$this->sampleName}Request.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Api/V1/{$this->sampleName}Request.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Requests/Site/{$this->sampleName}Request.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName.'/routes/admin.php'));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName.'/routes/api.php'));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName.'/routes/web.php'));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$lowerSampleName}/form.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$lowerSampleName}/index.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$lowerSampleName}/search-form.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$lowerSampleName}/show.blade.php"));

        $this->assertFileExists(app_path('Modules/'.$moduleName.'/views/admin/menu.blade.php'));
    }
}
