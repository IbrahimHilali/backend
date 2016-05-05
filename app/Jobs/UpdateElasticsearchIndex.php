<?php

namespace App\Jobs;

use App\Deployment\PlainArraySerializer;
use App\Deployment\Transformers\PersonTransformer;
use App\Events\DeployProgress;
use App\Jobs\Job;
use App\Deployment\DeploymentService;
use Carbon\Carbon;
use Cviebrock\LaravelElasticsearch\Manager;
use Grimm\Person;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Item;

class UpdateElasticsearchIndex extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $deployUntil;
    /**
     * @var User
     */
    private $initiator;

    protected $progress = 0;

    /**
     * Create a new job instance.
     *
     * @param Carbon $deployUntil The latest possible entry date
     * @param User   $initiator
     */
    public function __construct(Carbon $deployUntil, User $initiator)
    {
        $this->deployUntil = $deployUntil;
        $this->initiator = $initiator;
    }

    /**
     * Execute the job.
     *
     * @param DeploymentService $deployment
     * @param Manager           $elasticSearch
     * @param FractalManager    $fractal
     */
    public function handle(DeploymentService $deployment, Manager $elasticSearch, FractalManager $fractal)
    {
        $fractal->setSerializer(new PlainArraySerializer());

        if ($deployment->blank()) {
            $this->deployBlankPersons($elasticSearch, $fractal, $this->initiator);
        }
        $deployment->setInProgress(false);
        $deployment->setLast();
    }

    /**
     * @param Manager        $elasticsearch
     * @param FractalManager $fractal
     * @param User           $initiator
     */
    private function deployBlankPersons(Manager $elasticsearch, FractalManager $fractal, User $initiator)
    {
        Person::fullInfo()->chunk(200,
            function ($persons) use ($elasticsearch, $fractal, $initiator) {
                $params = ['body' => []];
                $personTransformer = new PersonTransformer();
                foreach ($persons as $person) {
                    // Metadata
                    $params['body'][] = [
                        'index' => [
                            '_index' => 'grimm',
                            '_type' => 'person',
                            '_id' => $person->id,
                        ],
                    ];
                    $item = new Item($person, $personTransformer);

                    $params['body'][] = $fractal->createData($item)->toArray();
                }

                $elasticsearch->bulk($params);
                
                $this->progress = $this->progress + count($persons);

                event(new DeployProgress($this->progress, Person::class, $initiator));
            });
    }
}
