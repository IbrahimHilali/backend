<?php

namespace App\Deployment\Transformers;

use App\Deployment\MappingProvider;
use Grimm\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract implements MappingProvider
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'personAssociations',
    ];

    protected $defaultIncludes = [
        'personAssociations',
    ];

    /**
     * Transforms a single item into a new one
     *
     * @param \Grimm\Book $item
     *
     * @return mixed
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item->id,
            'title' => $item->title,
            'short_title' => $item->short_title,
            'volume' => $item->volume,
            'volume_irregular' => $item->volume_irregular,
            'edition' => $item->edition,
            // 'year' => (int)$item->year,
            'grimmwerk' => $item->grimm,
            'notes' => $item->notes,
        ];
    }

    /**
     * Include person association
     *
     * @param \Grimm\Book $book
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includePersonAssociations(Book $book)
    {
        return $this->collection($book->personAssociations, new BookPersonAssociationTransformer);
    }

    public function mappings()
    {
        return [
            'book' => [
                'properties' => [
                    'id' => [
                        'type' => 'long',
                    ],
                    'grimmwerk' => [
                        'type' => 'boolean',
                    ],
                    'notes' => [
                        'type' => 'string',
                    ],
                    'short_title' => [
                        'type' => 'string',
                    ],
                    'title' => [
                        'type' => 'string',
                    ],
                    'volume' => [
                        'type' => 'long',
                    ],
                    'volume_irregular' => [
                        'type' => 'long',
                    ],
                    'edition' => [
                        'type' => 'string',
                    ],
                ],
            ],
        ];
    }
}
