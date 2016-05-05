<?php

namespace App\Jobs;

use App\Deployment\PlainArraySerializer;
use App\Deployment\Transformers\PersonTransformer;
use App\Jobs\Job;
use App\Deployment\DeploymentService;
use Carbon\Carbon;
use Cviebrock\LaravelElasticsearch\Manager;
use Grimm\Person;
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
     * Create a new job instance.
     *
     * @param $deployUntil Carbon The latest possible entry date
     */
    public function __construct(Carbon $deployUntil)
    {
        $this->deployUntil = $deployUntil;
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
            $this->deployBlankPersons($elasticSearch, $fractal);
        }
    }

    /**
     * @param Manager        $elasticsearch
     * @param FractalManager $fractal
     */
    private function deployBlankPersons(Manager $elasticsearch, FractalManager $fractal)
    {
        Person::fullInfo()->chunk(200, function ($persons) use ($elasticsearch, $fractal) {
            $params = ['body' => []];
            $personTransformer = new PersonTransformer();
            foreach ($persons as $person) {
                $params['body'][] = [
                    'index' => [
                        '_index' => 'grimm',
                        '_type' => 'person',
                        '_id' => $person->id,
                    ],
                ];
                $item = new Item($person, $personTransformer);

                $params['body'][] = $fractal->createData($item)->toArray();
                //dd($params);
            }

            $elasticsearch->bulk($params);

        });
    }
}
