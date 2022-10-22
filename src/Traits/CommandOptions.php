<?php

namespace Sedehi\LaravelModule\Traits;

use Symfony\Component\Console\Input\InputOption;

trait CommandOptions
{
    protected function getOptions()
    {
        $options = parent::getOptions();
        $options = array_merge($options, [
            ['module', null, InputOption::VALUE_OPTIONAL, 'The name of the module'],
            ['in', false, InputOption::VALUE_NONE, 'Interactive mode'],
        ]);

        return $options;
    }
}
