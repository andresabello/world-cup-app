<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetSquads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:squads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets all squads and stores as csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
