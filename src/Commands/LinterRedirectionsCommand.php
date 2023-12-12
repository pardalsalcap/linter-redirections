<?php

namespace Pardalsalcap\LinterRedirections\Commands;

use Illuminate\Console\Command;

class LinterRedirectionsCommand extends Command
{
    public $signature = 'linter-redirections';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
