<?php

namespace App\Sync;

use Spatie\Valuestore\Valuestore;

class DeploymentService
{

    /**
     * @var Valuestore
     */
    private $valuestore;

    public function __construct(Valuestore $valuestore)
    {
        $this->valuestore = $valuestore;
    }

    public function last()
    {
        return $this->valuestore->get('last-deployment', null);
    }

    public function inProgress()
    {
        return $this->valuestore->get('deployment-running', false);
    }
}
