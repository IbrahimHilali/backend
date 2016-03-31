<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonthlyReport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a monthly report and sends it to the Administrators';

    /**
     * Create a new command instance.
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
        // TODO: create report
        // send it to administrators (maybe with Role "receives reports"?)
    }
}
