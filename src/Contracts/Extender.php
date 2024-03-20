<?php

namespace Kanuni\LaravelBladeAnchor\Contracts;

use Illuminate\Contracts\Support\Htmlable;

interface Extender
{
    public function __invoke(?array $variables): string|Htmlable;
}
