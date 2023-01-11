<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeListenerTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_new_listener_class()
    {
        $this->artisan('make:listener', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Listeners/{$this->sampleName}.php"));
    }

    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_listener_class_interactive()
    {
        $this->artisan('make:listener', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('Enter event name: [optional]', $this->sampleName)
            ->assertExitCode(0);
    }
}
