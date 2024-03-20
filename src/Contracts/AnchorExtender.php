<?php

namespace Kanuni\LaravelBladeAnchor\Contracts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;

interface AnchorExtender
{
    public function __invoke(?array $variables): string|Htmlable|Renderable|null;
}
