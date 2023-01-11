<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeEventTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_new_event_class()
    {
        $this->artisan('make:event', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Events/{$this->sampleName}.php"));
    }

    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_event_class_interactive()
    {
        $this->artisan('make:event', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
