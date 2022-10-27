<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;
use Sedehi\LaravelModule\Commands\Questions\ClassType;
use Sedehi\LaravelModule\Commands\Questions\ControllerType;
use Sedehi\LaravelModule\Commands\Questions\ModuleName;
use Sedehi\LaravelModule\Traits\Interactive;
use Sedehi\LaravelModule\Traits\ModuleNameOption;
use Symfony\Component\Console\Input\InputOption;

class MakeController extends ControllerMakeCommand implements ModuleName, ControllerType, ClassType
{
    use Interactive,ModuleNameOption;

    protected function getOptions()
    {
        $options = parent::getOptions();
        $options = array_merge($options, [
            ['module', null, InputOption::VALUE_OPTIONAL, 'The name of the module'],
            ['in', false, InputOption::VALUE_NONE, 'Interactive mode'],
            ['crud', null, InputOption::VALUE_NONE, 'Generate a crud controller class'],
            ['upload', null, InputOption::VALUE_NONE, 'Generate an upload controller class'],
            ['site', null, InputOption::VALUE_NONE, 'Generate a site controller class'],
            ['admin', null, InputOption::VALUE_NONE, 'Generate an admin controller class'],
            ['api-version', null, InputOption::VALUE_OPTIONAL, 'Set Api version'],
            ['custom-views', null, InputOption::VALUE_NONE, 'Generate views from old stubs'],
        ]);

        return $options;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace;
        if ($this->option('module')) {
            $namespace .= '\\Modules\\'.Str::studly($this->option('module')).'\\Controllers';
        } else {
            $namespace .= '\Http\Controllers';
        }
        if ($this->option('site')) {
            $namespace .= '\\Site';
        }
        if ($this->option('admin')) {
            $namespace .= '\\Admin';
        }
        if ($this->option('api')) {
            $namespace .= '\\Api';
            if (! is_null($this->option('api-version'))) {
                $namespace .= '\\'.Str::studly($this->option('api-version'));
            }
        }

        return $namespace;
    }

    protected function getStub()
    {
        if ($this->option('crud') && $this->option('model')) {
            if ($this->option('custom-views')) {
                return __DIR__.'/stubs/controller-crud.stub';
            }

            return __DIR__.'/stubs/controller-crud-dynamic.stub';
        }
        if ($this->option('upload') && $this->option('model')) {
            if ($this->option('custom-views')) {
                return __DIR__.'/stubs/controller-upload.stub';
            }

            return __DIR__.'/stubs/controller-upload-dynamic.stub';
        }

        return parent::getStub();
    }

    public function handle()
    {
        $this->interactive();

        if ($this->option('crud')) {
            if (! $this->option('model')) {
                $this->error('You should specify model when using crud option');

                return false;
            }
        }

        return parent::handle();
    }

    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        if ($this->option('module')) {
            $replace = $this->buildModuleReplacements($replace);
            $replace = $this->buildViewsReplacements($replace);
            $replace = $this->buildRequestReplacements($replace);
            $replace = $this->buildActionReplacements($replace);
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), GeneratorCommand::buildClass($name)
        );
    }

    protected function buildParentReplacements()
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        if ($this->option('module')) {
            $parentModelClass = $this->laravel->getNamespace().'Modules\\'.Str::studly($this->option('module')).'\\Models\\'.Str::studly($this->option('parent'));
        }

        if (! class_exists($parentModelClass)) {
            if ($this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', [
                    'name' => $parentModelClass,
                    '--module' => $this->option('module'),
                ]);
            }
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            '{{ namespacedParentModel }}' => $parentModelClass,
            '{{namespacedParentModel}}' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            '{{ parentModel }}' => class_basename($parentModelClass),
            '{{parentModel}}' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
            '{{ parentModelVariable }}' => lcfirst(class_basename($parentModelClass)),
            '{{parentModelVariable}}' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if ($this->option('module')) {
            $modelClass = $this->laravel->getNamespace().'Modules\\'.Str::studly($this->option('module')).'\\Models\\'.Str::studly($this->option('model'));
        }
        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', [
                    'name' => $modelClass,
                    '--module' => $this->option('module'),
                ]);
            }
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ]);
    }

    protected function buildModuleReplacements($replace)
    {
        $module = Str::studly($this->option('module'));

        return array_merge($replace, [
            'DummySectionNormal' => $module,
            'DummySectionLower' => strtolower($module),
        ]);
    }

    protected function buildViewsReplacements($replace)
    {
        $viewForm = strtolower($this->nameWithoutController());

        if ($this->option('module')) {
            $path = Str::studly($this->option('module')).'.views.'.$this->type().'.'.strtolower($this->option('module'));
        } else {
            $path = 'views.'.$viewForm;
        }

        return array_merge($replace, [
            'DummyViewPath' => $path,
            'DummyViewForm' => $viewForm,
        ]);
    }

    protected function buildActionReplacements($replace)
    {
        if ($this->option('module')) {
            $path = Str::studly($this->option('module')).'\\Controllers\\'.Str::studly($this->type()).'\\'.Str::studly($this->argument('name'));
        } else {
            $path = Str::studly($this->argument('name'));
        }

        return array_merge($replace, [
            'DummyAction' => $path,
        ]);
    }

    protected function buildRequestReplacements($replace)
    {
        $requestClass = $this->getRequestClass();
        if ($this->option('module')) {
            if (! class_exists($requestClass)) {
                if ($this->confirm("A {$requestClass} Request does not exist. Do you want to generate it?", true)) {
                    $this->call('make:request', [
                        'name' => Str::studly($this->nameWithoutController()).'Request',
                        '--module' => $this->option('module'),
                        '--admin' => $this->option('admin'),
                        '--site' => $this->option('site'),
                        '--api' => $this->option('api'),
                        '--api-version' => $this->option('api-version') ? $this->option('api-version') : 'V1',
                    ]);
                }
            }
        }

        return array_merge($replace, [
            'DummyFullRequestClass' => ($this->option('module')) ? $requestClass : 'Illuminate\Http\Request',
            'DummyRequestClass' => ($this->option('module')) ? Str::studly($this->nameWithoutController()).'Request' : 'Request',
        ]);
    }

    protected function type()
    {
        if ($this->option('api')) {
            return 'api';
        } elseif ($this->option('site')) {
            return 'site';
        } elseif ($this->option('admin')) {
            return 'admin';
        }
    }

    protected function nameWithoutController()
    {
        return str_replace('Controller', '', $this->argument('name'));
    }

    protected function getRequestClass()
    {
        $class = $this->laravel->getNamespace().'Modules\\'.Str::studly($this->option('module')).'\\Requests\\';

        if ($this->option('api')) {
            if ($this->option('api-version')) {
                $class .= 'Api\\'.Str::studly($this->option('api-version')).'\\';
            } else {
                $class .= 'Api\\V1\\';
            }
        } elseif ($this->option('site')) {
            $class .= 'Site\\';
        } elseif ($this->option('admin')) {
            $class .= 'Admin\\';
        }

        $class .= Str::studly($this->nameWithoutController()).'Request';

        return $class;
    }
}
