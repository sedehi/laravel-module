<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view
                            {module : The name of the module}
                            {name : The name of the folder}
                            {controller : The name of controller}
                            {--upload}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create module views';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $viewPath = 'views/admin/'.strtolower($this->argument('name')).'/';
        if (! File::isDirectory(app_path('Modules/'.ucfirst($this->argument('module')).'/'.$viewPath))) {
            File::makeDirectory(app_path('Modules/'.ucfirst($this->argument('module')).'/'.$viewPath), 0775, true);
        }
        $stubFolder = 'dynamic';
        if ($this->option('upload')) {
            $stubPath = __DIR__.'/stubs/views/'.$stubFolder.'/with-upload/';
            foreach (File::files($stubPath) as $templateFile) {
                if (File::exists(app_path('Modules/'.ucfirst($this->argument('module')).'/views/admin/'.strtolower($this->argument('name')).'/'.File::name($templateFile).'.blade.php'))) {
                    $this->error('Admin '.File::name($templateFile).' view already exists.');
                } else {
                    if (File::exists(resource_path('section-stubs/'.$stubFolder.'/with-upload/'.File::name($templateFile).'.stub'))) {
                        $data = File::get(resource_path('section-stubs/'.$stubFolder.'/with-upload/'.File::name($templateFile).'.stub'));
                    } else {
                        $data = File::get($stubPath.File::name($templateFile));
                    }
                    $data = str_replace([
                        '{{{section}}}',
                        '{{{sectionLower}}}',
                        '{{{controller}}}',
                        '{{{controllerLower}}}',
                        '{{{name}}}',
                    ], [
                        ucfirst($this->argument('module')),
                        strtolower($this->argument('module')),
                        ucfirst($this->argument('controller')),
                        strtolower($this->argument('controller')),
                        strtolower($this->argument('name')),
                    ], $data);
                    File::put(app_path('Modules/'.ucfirst($this->argument('module')).'/views/admin/'.strtolower($this->argument('name')).'/'.File::name($templateFile).'.blade.php'), $data);
                    $this->info('Admin '.File::name($templateFile).' view created successfully.');
                }
            }
        } else {
            $stubPath = __DIR__.'/stubs/views/'.$stubFolder.'/';
            foreach (File::files($stubPath) as $templateFile) {
                if (File::exists(app_path('Modules/'.ucfirst($this->argument('module')).'/views/admin/'.strtolower($this->argument('name')).'/'.File::name($templateFile).'.blade.php'))) {
                    $this->error('Admin '.File::name($templateFile).' view already exists.');
                } else {
                    if (File::exists(resource_path('module-stubs/'.$stubFolder.'/'.File::name($templateFile).'.stub'))) {
                        $data = File::get(resource_path('module-stubs/'.$stubFolder.'/'.File::name($templateFile).'.stub'));
                    } else {
                        $data = File::get($stubPath.File::name($templateFile));
                    }
                    $data = str_replace([
                        '{{{module}}}',
                        '{{{moduleLower}}}',
                        '{{{name}}}',
                        '{{{controller}}}',
                        '{{{controllerLower}}}',
                    ], [
                        ucfirst($this->argument('module')),
                        strtolower($this->argument('module')),
                        strtolower($this->argument('name')),
                        ucfirst($this->argument('controller')),
                        strtolower($this->argument('controller')),
                    ], $data);
                    File::put(app_path('Modules/'.ucfirst($this->argument('module')).'/views/admin/'.strtolower($this->argument('name')).'/'.File::name($templateFile).'.blade.php'), $data);
                    $this->info('Admin '.File::name($templateFile).' view created successfully.');
                }
            }
        }
    }
}
