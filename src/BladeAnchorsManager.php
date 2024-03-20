<?php

namespace Kanuni\LaravelBladeAnchor;

use Illuminate\Support\Facades\View;
use Kanuni\LaravelBladeAnchor\Contracts\AnchorExtender;

class BladeAnchorsManager
{
    private static array $extenders = [];

    /**
     * Register anchor extender class on specified anchor
     *
     * @param string $view
     * @param string $anchor
     * @param string $extenderClass
     * @return boolean
     */
    public function registerExtender(string $view, string $anchor, string $extenderClass): bool
    {
        if (! View::exists($view)) return false;
        if (! class_exists($extenderClass)) return false;
        if (! in_array(AnchorExtender::class, class_implements($extenderClass))) return false;

        $anchorPath = $this->getExtendersPath($view, $anchor);

        if (array_key_exists($anchorPath, static::$extenders)) {
            // Push extender to extenders array
            static::$extenders[$anchorPath][] = $extenderClass;
        } else {
            // Create new array for the path and add extender to it
            static::$extenders[$anchorPath] = [$extenderClass];
        }

        return true;
    }

    /**
     * Get all registered extenders for specified anchor.
     *
     * @param string $view
     * @param string $anchor
     * @return array
     */
    public function getExtenders(string $view, string $anchor): array
    {
        $path = $this->getExtendersPath($view, $anchor);

        return array_key_exists($path, static::$extenders)
            ? static::$extenders[$path]
            : [];
    }

    /**
     * Check if specified anchor has registered extenders
     *
     * @param string $view
     * @param string $anchor
     * @return boolean
     */
    public function hasExtenders(string $view, string $anchor): bool
    {
        return count($this->getExtenders($view, $anchor)) > 0;
    }

    /**
     * Returns string path for specified anchor to be used in extenders registry
     *
     * @param string $view
     * @param string $anchor
     * @return string
     */
    protected function getExtendersPath(string $view, string $anchor): string
    {
        return "$view#$anchor";
    }
}
