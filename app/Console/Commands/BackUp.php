<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database, scans and more';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // TODO: create backup...
    }
}