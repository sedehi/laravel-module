<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\Interactive;
use Symfony\Component\Console\Input\InputOption;

class MakeTest extends TestMakeCommand implements ModuleName
{
    use Interactive;

    protected function getOptions()
    {
        $options = parent::getOptions();
        $options = array_merge($options, [
            ['module', null, InputOption::VALUE_OPTIONAL, 'The name of the module'],
            ['in', false, InputOption::VALUE_NONE, 'Interactive mode'],
            ['crud', null, InputOption::VALUE_NONE, 'Generate a crud test'],
            ['model', null, InputOption::VALUE_NONE, 'Name of the model crud test'],
            ['controller', null, InputOption::VALUE_NONE, 'Name of the controller for actions'],
            ['site', null, InputOption::VALUE_NONE, 'Generate admin crud test'],
            ['admin', null, InputOption::VALUE_NONE, 'Generate admin crud test'],
            ['api', null, InputOption::VALUE_NONE, 'Generate api crud test'],
            ['api-version', null, InputOption::VALUE_OPTIONAL, 'Set api version for test'],
        ]);

        return $options;
    }

    public function handle()
    {
        if ($this->option('module') && $this->option('crud')) {
            if (! $this->option('model')) {
                $this->error('You should specify model name if using crud option');

                return false;
            }
            if (! $this->option('controller')) {
                $this->error('You should specify controller name if using crud option');

                return false;
            }
        }

        $this->interactive();

        parent::handle();
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $name = str_replace('\\Tests\\', '\\tests\\', $name);
        if ($this->option('module') !== null) {
            return app_path().'/'.str_replace('\\', '/', $name).'.php';
        }

        return base_path('tests').str_replace('\\', '/', $name).'.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('module') == null) {
            return parent::getDefaultNamespace($rootNamespace);
        }

        $namespace = $rootNamespace.'\Modules\\'.Str::studly($this->option('module')).'\tests';

        if ($this->option('admin')) {
            $namespace .= '\Admin';
        } elseif ($this->option('site')) {
            $namespace .= '\Site';
        } elseif ($this->option('api')) {
            $namespace .= '\Api';
            if ($this->option('api-version')) {
                $namespace .= '\\'.Str::studly($this->option('api-version'));
            } else {
                $namespace .= '\\V1';
            }
        }

        if ($this->option('unit')) {
            $namespace .= '\Unit';
        } else {
            $namespace .= '\Feature';
        }

        return $namespace;
    }

    protected function rootNamespace()
    {
        if ($this->option('module') !== null) {
            return $this->laravel->getNamespace();
        }

        return 'Tests';
    }

    protected function getStub()
    {
        if ($this->option('module') == null || ! $this->option('crud')) {
            return parent::getStub();
        }

        if ($this->option('api')) {
            return __DIR__.'/stubs/test-crud-api.stub';
        }

        return __DIR__.'/stubs/test-crud.stub';
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);

        if ($this->option('module') && $this->option('crud')) {
            $stub = $this->replaceModel($stub);
            $stub = $this->replaceAction($stub);
        }

        return $stub;
    }

    protected function replaceModel(&$stub)
    {
        $modelClass = $this->laravel->getNamespace().'\Modules\\'.Str::studly($this->option('module')).'\\Models\\'.Str::studly($this->option('model'));

        $stub = str_replace(
            ['DummyFullModelClass', 'DummyModelClass'],
            [$modelClass, class_basename($modelClass)],
            $stub
        );

        return $stub;
    }

    protected function replaceAction($stub)
    {
        $action = Str::studly($this->option('module')).'\\Controllers\\';

        if ($this->option('admin')) {
            $action .= 'Admin\\';
        } elseif ($this->option('site')) {
            $action .= 'Site\\';
        } elseif ($this->option('api')) {
            $action .= 'Api\\';
            if ($this->option('api-version')) {
                $action .= Str::studly($this->option('api-version')).'\\';
            } else {
                $action .= 'V1\\';
            }
        }

        $action .= Str::studly($this->option('controller'));

        return str_replace('DummyFullControllerClass', $action, $stub);
    }
}
