<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\v1\AutobotsController;
use Illuminate\Console\Command;

class Autobots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:autobots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Autobots = new AutobotsController();
        $Autobots->autocreation();

    }
}
