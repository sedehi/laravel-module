<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeRuleTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_a_rule_class()
    {
        $this->artisan('make:rule', [
            'name' => $this->sampleName,
            '--module' => $this->moduleName,
        ]);

        $this->assertFileExists(app_path('Modules/'.$this->moduleName."/Rules/{$this->sampleName}.php"));
    }

    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_rule_class_interactive()
    {
        $this->artisan('make:rule', [
            'name' => $this->sampleName,
            '--in' => true,
        ])->expectsQuestion('Enter module name: [optional]', $this->moduleName)
            ->assertExitCode(0);
    }
}
