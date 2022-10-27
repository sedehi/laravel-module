<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeSeederTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_seeder_class()
    {
        $this->artisan('make:seeder', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/database/seeders/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_seeder_class_without_module_option()
    {
        $this->artisan('make:seeder', [
            'name' => $this->sampleName,
        ]);

        $this->assertFileExists(database_path("seeders/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_seeder_class_interactive()
    {
        $this->artisan('make:seeder', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
