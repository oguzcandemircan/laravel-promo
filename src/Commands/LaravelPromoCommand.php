<?php

namespace OguzcanDemircan\LaravelPromo\Commands;

use Illuminate\Console\Command;

class LaravelPromoCommand extends Command
{
    public $signature = 'laravel-promo';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
