<?php

namespace App\Deployment;

use App\Deployment\Transformers\BookTransformer;
use App\Deployment\Transformers\PersonTransformer;
use Cviebrock\LaravelElasticsearch\Manager;

class ElasticIndexService
{

    /**
     * @var Manager
     */
    private $elasticsearch;

    public function __construct(Manager $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function createIndex($name, $mappings)
    {
        $params = [
            'index' => $name,
            'body' => [
                'mappings' => $mappings,
            ],
        ];

        return $this->elasticsearch->indices()->create($params)['acknowledged'];
    }

    public function dropIndex($name)
    {
        return $this->elasticsearch->indices()->delete(['index' => $name])['acknowledged'];
    }

    public function mappingsFromProvider(array $providers = [])
    {
        if (empty($providers)) {
            $providers = [new PersonTransformer(), new BookTransformer()];
        }

        $mappings = array_map(function ($el) {
            return $el->mappings();
        }, $providers);

        return call_user_func_array('array_merge', $mappings);
    }
}
