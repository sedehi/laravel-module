<?php

namespace Sedehi\LaravelModule\Traits;

use Illuminate\Support\Str;

trait ModuleNameOption
{
    protected function getModuleName()
    {
        return Str::of($this->option('module'))->whenNotEmpty(function ($string){
            return $string->studly()->trim()->start('\\');
        });
    }
}
