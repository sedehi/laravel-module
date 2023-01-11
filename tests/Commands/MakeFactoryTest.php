<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_new_factory()
    {
        $this->artisan('make:factory', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);
        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/database/factories/{$this->sampleName}.php"));
    }

    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_factory_interactive()
    {
        $this->artisan('make:factory', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->expectsQuestion('Enter model name: [optional]', $this->sampleName)
            ->assertExitCode(0);
    }
}
