<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeExceptionTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_new_exception_class()
    {
        $this->artisan('make:exception', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Exceptions/{$this->sampleName}.php"));
    }

    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_exception_class_interactive()
    {
        $this->artisan('make:exception', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
