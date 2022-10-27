<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeCommandTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_make_a_new_command_class()
    {
        $this->artisan('make:command', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Commands/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function test_make_command_interactive()
    {
        $this->artisan('make:command', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
