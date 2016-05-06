<?php

namespace App\Deployment;

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
}
