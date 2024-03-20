<?php

namespace Kanuni\LaravelBladeAnchor\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeAnchorExtenderCommand extends GeneratorCommand
{
    public $signature = 'make:anchor-extender {name}';

    public $description = 'Create a new extender class that can be attached to anchor defined in laravel blade template.';

    public function getStub(): string
    {
        return __DIR__ . '../../stubs/anchor-extender.stub';
    }

    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\BladeExtenders';
    }
}
