<?php

namespace App\Deployment;

use Carbon\Carbon;
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

    /**
     * Get the date of the last deployment
     *
     * @return Carbon|null
     */
    public function last()
    {
        $last = $this->valuestore->get('last-deployment', null);

        if ($last !== null) {
            return new Carbon($last);
        }

        return null;
    }

    /**
     * Check if there has been a deployment
     * or if there has to be done a initial deployment
     *
     * @return bool
     */
    public function blank()
    {
        return $this->last() === null;
    }

    /**
     * Check if there is a deployment running
     *
     * @return bool
     */
    public function inProgress()
    {
        return $this->valuestore->get('deployment-running', false);
    }

    public function setInProgress($status = true)
    {
        return $this->valuestore->put('deployment-running', $status);
    }

    public function setLast($time = null)
    {
        if ($time === null) {
            $time = Carbon::now();
        }

        return $this->valuestore->put('last-deployment', $time->toIso8601String());
    }

    public function status()
    {
        return [
            'blank' => $this->blank(),
            'inProgress' => $this->inProgress(),
            'last' => ($this->last() !== null) ? $this->last()->toRfc822String() : null,
        ];
    }
}
