<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! File::isDirectory(app_path('Modules/'.Str::studly($this->argument('name'))))) {
            File::makeDirectory(app_path('Modules/'.Str::studly($this->argument('name'))), 0775, true);
        }

        $this->call('make:crud', [
            'module' => strtolower($this->argument('name')),
            'name' => strtolower($this->argument('name')),
        ]);

        File::copy(__DIR__.'/stubs/views/menu.blade.stub', app_path('Modules/'.Str::studly($this->argument('name')).'/views/admin/menu.blade.php'));
    }
}
