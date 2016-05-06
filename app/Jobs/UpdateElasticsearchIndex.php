<?php

namespace App\Jobs;

use App\Deployment\ElasticIndexService;
use App\Deployment\ModelDeployer;
use App\Deployment\PlainArraySerializer;
use App\Deployment\Transformers\BookTransformer;
use App\Deployment\Transformers\PersonTransformer;
use App\Events\DeploymentDone;
use App\Events\DeployProgress;
use App\Jobs\Job;
use App\Deployment\DeploymentService;
use Carbon\Carbon;
use Grimm\Book;
use Grimm\Person;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param DeploymentService   $deployment
     * @param ModelDeployer       $deployer
     *
     * @param ElasticIndexService $elasticIndexService
     */
    public function handle(
        DeploymentService $deployment,
        ModelDeployer $deployer,
        ElasticIndexService $elasticIndexService
    ) {

        $deployer->setSerializer(new PlainArraySerializer());

        if (!$deployment->blank()) {
            $elasticIndexService->dropIndex('grimm');
        }

        $personTransformer = new PersonTransformer();
        $bookTransformer = new BookTransformer();

        $mappings = array_merge($personTransformer->mappings(), $bookTransformer->mappings());

        $elasticIndexService->createIndex('grimm', $mappings);

        $people = $deployer->deploy(Person::fullInfo(), 'person', $personTransformer, function ($progress) {
            event(new DeployProgress($progress, Person::class, $this->initiator));
        });

        $books = $deployer->deploy(Book::with('personAssociations'), 'book', $bookTransformer, function ($progress) {
            event(new DeployProgress($progress, Book::class, $this->initiator));
        });

        event(new DeploymentDone($this->initiator, $people, $books));
        $deployment->setInProgress(false);
        $deployment->setLast();
    }

}
