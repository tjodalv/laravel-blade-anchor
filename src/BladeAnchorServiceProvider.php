<?php

namespace Kanuni\LaravelBladeAnchor;

use Kanuni\LaravelBladeAnchor\Blade\ExtendBlade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Kanuni\LaravelBladeAnchor\Commands\MakeBladeExtenderCommand;

class BladeAnchorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-blade-anchor')
            ->hasCommand(MakeBladeExtenderCommand::class);
    }

    public function bootingPackage()
    {
        // Register blade directive
        app(ExtendBlade::class)->boot();
    }
}
