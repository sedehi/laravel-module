<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeViewTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_crud_view_files()
    {
        $this->sampleName = $this->sampleName.'1';
        $this->artisan('make:view', [
            'module' => $this->moduleName,
            'name' => $this->sampleName,
            'controller' => 'FakeController',
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/form.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/index.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/show.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/search-form.blade.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_crud_with_upload_view_files()
    {
        $this->sampleName = $this->sampleName.'2';
        $this->artisan('make:view', [
            'module' => $this->moduleName,
            'name' => $this->sampleName,
            'controller' => 'FakeController',
            '--upload' => true,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/form.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/index.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/show.blade.php"));
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/views/admin/{$this->sampleName}/search-form.blade.php"));
    }
}
