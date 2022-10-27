<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeChannelTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_can_make_a_new_channel_class()
    {
        $this->artisan('make:channel', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Channels/{$this->sampleName}.php"));
    }

    /**
     * @return void
     * @test
     */
    public function it_can_make_channel_class_interactive()
    {
        $this->artisan('make:channel', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
