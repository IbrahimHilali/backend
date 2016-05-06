<?php

namespace App\Deployment;

use Cviebrock\LaravelElasticsearch\Manager;
use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;

class ModelDeployer
{

    protected $progress = 0;

    protected $chunkSize = 200;

    /**
     * @var Manager
     */
    private $elasticsearch;
    /**
     * @var FractalManager
     */
    private $fractal;

    public function __construct(Manager $elasticsearch, FractalManager $fractal)
    {
        $this->elasticsearch = $elasticsearch;
        $this->fractal = $fractal;
    }

    public function setSerializer(SerializerAbstract $serializerAbstract)
    {
        $this->fractal->setSerializer($serializerAbstract);
        
        return $this;
    }

    public function deploy(Builder $builder, $transformer, callable $progressCallback)
    {
        $this->progress = 0;

        $builder->chunk($this->chunkSize, function ($rows) use ($transformer, $progressCallback) {
            $params = ['body' => []];

            foreach ($rows as $row) {
                // Metadata
                $params['body'][] = [
                    'index' => [
                        '_index' => 'grimm',
                        '_type' => 'person',
                        '_id' => $row->id,
                    ],
                ];

                $item = new Item($row, $transformer);

                $params['body'][] = $this->fractal->createData($item)->toArray();
            }

            $this->elasticsearch->bulk($params);

            $this->progress = $this->progress + count($rows);

            call_user_func($progressCallback, $this->progress);
        });

        return $this->progress;
    }

    /**
     * @return int
     */
    public function getProgress()
    {
        return $this->progress;
    }
}
