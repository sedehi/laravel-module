<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeObserverTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_make_a_new_observer_class()
    {
        $this->artisan('make:observer', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Observers/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_observer_class_interactive()
    {
        $this->artisan('make:observer', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('Enter model name: [optional]', $this->sampleName)
            ->assertExitCode(0);
    }
}
