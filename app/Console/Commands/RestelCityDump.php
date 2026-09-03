<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FrontEnd\Hotel\StaticController;

class RestelCityDump extends Command
{
        protected $signature = 'restel:city-dump';

    /**
     * The console command description.
     */
    protected $description = 'Run Restel City Dump process';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // If your logic is in controller method
        $controller = new StaticController();
        $controller->getRestelCity();

        // or directly run your logic here

        $this->info('Restel City Dump executed successfully.');
    }

}
