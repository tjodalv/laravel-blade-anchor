<?php

namespace Kanuni\LaravelBladeAnchor;

use Kanuni\LaravelBladeAnchor\Blade\ExtendBlade;
use Kanuni\LaravelBladeAnchor\Commands\MakeAnchorExtenderCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommand(MakeAnchorExtenderCommand::class);
    }

    public function bootingPackage()
    {
        // Register blade directive
        app(ExtendBlade::class)->boot();
    }
}
