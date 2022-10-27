<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeCastTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_a_new_cast_class()
    {
        $this->artisan('make:cast', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Casts/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_cast_class_interactive()
    {
        $this->artisan('make:cast', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
