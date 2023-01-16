<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud
                            {module : The name of the module}
                            {name : The name of the crud}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new crud';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $adminController = $siteController = $apiController = false;
        if ($this->confirm('Do you want to create model ?', true)) {
            $this->makeModel();
        }
        if ($this->confirm('Do you want to create admin controller ?', true)) {
            $adminController = true;
            if ($this->confirm('Do you want to upload picture in admin ?', true)) {
                $this->makeAdminControllerWithUpload();
            } else {
                $this->makeAdminController();
            }
            if ($this->confirm('Do you want to create permission seeder ?', true)) {
                $this->makePermissionSeeder();
            }
        }
        if ($this->confirm('Do you want to create site controller ?', true)) {
            $siteController = true;
            $this->makeSiteController();
        }
        if ($this->confirm('Do you want to create api controller ?', true)) {
            $apiController = true;
            $this->makeApiController();
        }
        if ($this->confirm('Do you want to create factory ?', true)) {
            $this->makeFactory();
        }
        if ($this->confirm('Do you want to create migration ?', true)) {
            $name = $this->ask('What is table name?');
            $this->makeMigration($name ?? $this->argument('name'));
        }
        if ($this->confirm('Do you want to create route ?', true)) {
            $this->makeRoute($adminController, $siteController, $apiController);
        }
    }

    private function makeModel()
    {
        $this->call('make:model', ['--module' => $this->argument('module'), 'name' => Str::studly($this->argument('name'))]);
    }

    private function makeAdminController()
    {
        $this->call('make:controller', [
            '--module' => $this->argument('module'),
            'name' => ucfirst($this->argument('name')).'Controller',
            '--admin' => true,
            '--crud' => true,
            '--model' => Str::studly($this->argument('name')),
        ]);
        $this->call('make:view', [
            'module' => $this->argument('module'),
            'name' => strtolower($this->argument('name')),
            'controller' => ucfirst($this->argument('name')).'Controller',
        ]);
    }

    private function makeAdminControllerWithUpload()
    {
        $this->call('make:controller', [
            '--module' => $this->argument('module'),
            'name' => ucfirst($this->argument('name')).'Controller',
            '--upload' => true,
            '--admin' => true,
        ]);
        $this->call('make:view', [
            'name' => strtolower($this->argument('name')),
            'module' => $this->argument('module'),
            'controller' => ucfirst($this->argument('name')).'Controller',
            '--upload' => true,
        ]);
    }

    private function makeSiteController()
    {
        $this->call('make:controller', [
            '--module' => ucfirst($this->argument('module')),
            'name' => ucfirst($this->argument('name')).'Controller',
            '--site' => true,
        ]);
        if (! File::isDirectory(app_path('Modules/'.ucfirst($this->argument('module')).'/views/site/'))) {
            File::makeDirectory(app_path('Modules/'.ucfirst($this->argument('module')).'/views/site/'), 0775, true);
        }
    }

    private function makeMigration($name)
    {
        $this->call('make:migration', [
            '--module' => ucfirst($this->argument('module')),
            'name' => 'create_'.$name.'_table',
        ]);
    }

    private function makePermissionSeeder()
    {
        $this->call('make:seeder', [
            '--module' => ucfirst($this->argument('module')),
            'name' => 'AdminPermissionSeeder',
        ]);
    }

    private function makeApiController()
    {
        $this->call('make:controller', [
            '--module' => ucfirst($this->argument('module')),
            'name' => ucfirst($this->argument('name')).'Controller',
            '--api' => true,
            '--api-version' => 'v1',
        ]);
    }

    private function makeRoute($adminController, $siteController, $apiController)
    {
        if (! File::isDirectory(app_path('Modules/'.ucfirst($this->argument('module')).'/'.'routes'))) {
            File::makeDirectory(app_path('Modules/'.ucfirst($this->argument('module')).'/'.'routes'), 0775, true);
        }
        if ($siteController) {
            if (File::exists(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'web.php'))) {
                $this->error('web route already exists.');
            } else {
                File::put(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'web.php'), '<?php ');
                $this->info('web route created successfully.');
            }
        }
        if ($adminController) {
            if (File::exists(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'admin.php'))) {
                $this->error('admin route already exists.');
            } else {
                File::put(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'admin.php'), '<?php ');
                $data = File::get(__DIR__.'/stubs/route-admin.stub');
                $data = str_replace('{{{name}}}', ucfirst($this->argument('module')), $data);
                $data = str_replace('{{{controller}}}', ucfirst($this->argument('name')).'Controller', $data);
                $data = str_replace('{{{url}}}', strtolower($this->argument('name')), $data);
                File::append(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'admin.php'), $data);
                $this->info('admin route created successfully.');
            }
        }
        if ($apiController) {
            if (File::exists(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'api.php'))) {
                $this->error('api route already exists.');
            } else {
                File::put(app_path('Modules/'.ucfirst($this->argument('module')).'/routes/'.'api.php'), '<?php ');
                $this->info('api route created successfully.');
            }
        }
    }

    private function makeFactory()
    {
        $this->call('make:factory', [
            'name' => ucfirst($this->argument('name')).'Factory',
            '--module' => ucfirst($this->argument('module')),
            '--model' => $this->laravel->getNamespace().'Modules\\'.Str::studly($this->argument('module')).
                '\\Models\\'.Str::studly($this->argument('name')),
        ]);
    }
}
