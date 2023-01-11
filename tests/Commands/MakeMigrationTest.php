<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeMigrationTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function it_can_make_migration_class()
    {
        $name = 'create_test_table';
        $this->artisan('make:migration', [
            'name' => $name,
            '--module' => $this->moduleName,
        ]);
        $migration = glob(app_path('Modules/'.$this->moduleName.'/database/migrations/*_create_test_table.php'));
        $this->assertCount(1, $migration);
    }
}
