<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Deployment\DeploymentService;
use Cviebrock\LaravelElasticsearch\Manager;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateElasticsearchIndex extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $deployUntil;

    /**
     * Create a new job instance.
     *
     * @param $deployUntil The latest possible entry date
     */
    public function __construct($deployUntil)
    {
        $this->deployUntil = $deployUntil;
    }

    /**
     * Execute the job.
     *
     * @param DeploymentService $deployment
     * @param Manager           $elasticSearch
     */
    public function handle(DeploymentService $deployment, Manager $elasticSearch)
    {
        if ($deployment->blank()) {
            $this->deployBlankPersons($elasticSearch);
        }
    }

    /**
     * @param Manager $elasticsearch
     */
    private function deployBlankPersons(Manager $elasticsearch)
    {

    }
}
