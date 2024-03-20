<?php

namespace Kanuni\LaravelBladeAnchor\Commands;

use Illuminate\Console\Command;

class MakeBladeExtenderCommand extends Command
{
    public $signature = 'make:blade-extender';

    public $description = 'Create new blade extender class that can be attached to anchor defined in blade template.';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
