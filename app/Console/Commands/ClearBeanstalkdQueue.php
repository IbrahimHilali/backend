<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pheanstalk\Pheanstalk;
use Queue;

class ClearBeanstalkdQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:clear {queue?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all jobs from the given queue';

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
        $queue = ($this->argument('queue')) ? $this->argument('queue') : config('queue.connections.beanstalkd.queue');

        $this->info('Clearing queue ' . $queue);

        /** @var Pheanstalk $pheanstalk */
        $pheanstalk = Queue::getPheanstalk();

        $pheanstalk->useTube($queue);
        $pheanstalk->watch($queue);

        while ($job = $pheanstalk->reserve(0)) {
            $pheanstalk->delete($job);
        }

        $this->info('All jobs cleared');
    }
}
