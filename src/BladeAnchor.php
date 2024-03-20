<?php

namespace Kanuni\LaravelBladeAnchor;

use Illuminate\Support\Facades\View;
use Kanuni\LaravelBladeAnchor\Contracts\Extender;

class BladeAnchor
{
    private static array $extenders = [];

    public function registerExtender(string $view, string $anchor, string $extender): bool
    {
        if (! View::exists($view)) return false;
        if (! class_exists($extender)) return false;

        $anchorPath = "$view#$anchor";
        $resolvedExtender = app($extender);

        $this->addAnchorExtender($anchorPath, $resolvedExtender);

        return true;
    }

    protected function addAnchorExtender(string $anchorPath, Extender $extender)
    {
        if (array_key_exists($anchorPath, static::$extenders)) {
            // Push extender to extenders array
            static::$extenders[$anchorPath][] = $extender;
        } else {
            // Create new array for the path and add extender to it
            static::$extenders[$anchorPath] = [$extender];
        }
    }

    public function getExtenders(string $view, string $anchor): array
    {
        $path = "$view#$anchor";

        return array_key_exists($path, static::$extenders)
            ? static::$extenders[$path]
            : [];
    }
}
