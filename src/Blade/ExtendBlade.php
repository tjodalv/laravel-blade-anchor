<?php

namespace Kanuni\LaravelBladeAnchor\Blade;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class ExtendBlade
{
    public function boot()
    {
        View::creator('*', function (\Illuminate\View\View $view) {
            $view->with('__current_view_name', $view->getName());
        });

        Blade::directive('anchor', function (string $anchorName) {
            return <<<DIRECTIVE
                <?php
                foreach (
                    \Kanuni\LaravelBladeAnchor\Facades\LaravelBladeAnchor::getExtenders(\$__current_view_name, $anchorName)
                    as \$extender
                ) {
                    \$extender(get_defined_vars());
                }
                ?>
            DIRECTIVE;
        });
    }
}
