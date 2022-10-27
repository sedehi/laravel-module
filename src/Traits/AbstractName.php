<?php

namespace Sedehi\LaravelModule\Traits;

trait AbstractName
{
    protected function abstractName($stringName, $class)
    {
        $abstractName = $stringName;
        if (version_compare($this->app->version(), '9', '>=')) {
            $abstractName = $class;
        }

        return $abstractName;
    }
}
