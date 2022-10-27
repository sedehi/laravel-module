<?php

namespace Sedehi\LaravelModule\Tests\Commands;

use Sedehi\LaravelModule\Tests\TestCase;

class MakeMigrationTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function make_migration_with_section_option()
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
