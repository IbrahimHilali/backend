<?php

namespace App\Deployment\Transformers;

use Grimm\Person;
use League\Fractal\TransformerAbstract;

class PersonTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'information',
        'prints',
        'inheritances',
        'bookAssociations',
    ];

    protected $defaultIncludes = [
        'information',
        'prints',
        'inheritances',
        'bookAssociations',
    ];

    /**
     * Transforms a single item into a new one
     *
     * @param \Grimm\Person $item
     *
     * @return mixed
     */
    public function transform(Person $item)
    {
        return [
            'id' => (int)$item->id,
            'last_name' => $item->last_name,
            'first_name' => $item->first_name,
            'birth_date' => $item->birth_date,
            'death_date' => $item->death_date,
            'bio_data' => $item->bio_data,
            'bio_data_source' => $item->bio_data_source,
            'add_bio_data' => $item->add_bio_data,
            'is_organization' => (bool)$item->is_organization,
            'auto_generated' => (bool)$item->auto_generated,
            'source' => $item->source,
        ];
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInformation(Person $person)
    {
        return $this->collection($person->information, new PersonInformationTransformer);
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includePrints(Person $person)
    {
        return $this->collection($person->prints, new PersonPrintTransformer);
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInheritances(Person $person)
    {
        return $this->collection($person->inheritances, new PersonInheritanceTransformer);
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBookAssociations(Person $person)
    {
        return $this->collection($person->bookAssociations, new BookPersonAssociationTransformer);
    }

    public function mappings()
    {
        return [
            'person' => [
                'properties' => [
                    'first_name' => [
                        'type' => 'string',
                        'copy_to' => 'name',
                    ],
                    'last_name' => [
                        'type' => 'string',
                        'copy_to' => 'name',
                        'boost' => 2,
                    ],
                    'name' => [
                        'type' => 'string',
                    ],
                    'add_bio_data' => [
                        'type' => 'string',
                    ],
                    'auto_generated' => [
                        'type' => 'boolean',
                    ],
                    'bio_data' => [
                        'type' => 'string',
                    ],
                    'bio_data_source' => [
                        'type' => 'string',
                    ],
                    'birth_date' => [
                        'type' => 'string',
                    ],
                    'death_date' => [
                        'type' => 'string',
                    ],
                    'id' => [
                        'type' => 'long',
                    ],
                    'inheritances' => [
                        'properties' => [
                            'entry' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'is_organization' => [
                        'type' => 'boolean',
                    ],
                    'prints' => [
                        'properties' => [
                            'entry' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'source' => [
                        'type' => 'string',
                    ],
                ],
            ],
        ];
    }
}
