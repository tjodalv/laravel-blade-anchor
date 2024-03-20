<?php

namespace Kanuni\LaravelBladeAnchor\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kanuni\LaravelBladeAnchor\LaravelBladeAnchor
 */
class LaravelBladeAnchor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kanuni\LaravelBladeAnchor\BladeAnchorsManager::class;
    }
}
