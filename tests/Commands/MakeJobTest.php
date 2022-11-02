<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeJobTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_a_new_job_class()
    {
        $this->artisan('make:job', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Jobs/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_a_new_job_class_as_an_action()
    {
        $this->artisan('make:job', [
            'name' => $this->sampleName,
            '--action' => true,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Actions/{$this->sampleName}.php"));

    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_job_class_interactive()
    {
        $this->artisan('make:job', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
