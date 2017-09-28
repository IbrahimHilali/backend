<?php

namespace App\Library\Services;

use App\Library\Services\Exceptions\InvalidRelationTypeException;
use Grimm\LibraryBook;
use Grimm\LibraryPerson;

class LibraryRelationService
{

    protected $relationTypes = [
        'author',
        'editor',
        'translator',
        'illustrator',
    ];

    /**
     * @param LibraryBook $book
     * @param $relation
     * @param LibraryPerson $person
     * @return bool
     * @throws InvalidRelationTypeException
     */
    public function store(LibraryBook $book, $relation, LibraryPerson $person)
    {
        $this->guardAgainstUnknownRelationType($relation);

        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relationQuery */
        $relationQuery = $book->{str_plural($relation)}();

        try {
            $relationQuery->save($person);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $book
     * @param $relation
     * @param $person
     * @return bool
     * @throws InvalidRelationTypeException
     */
    public function delete($book, $relation, LibraryPerson $person)
    {
        $this->guardAgainstUnknownRelationType($relation);

        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relationQuery */
        $relationQuery = $book->{str_plural($relation)}();

        try {
            $relationQuery->detach([$person->id]);

            // a person in the library database can not exists without corresponding books
            if ($person->totalBookCount() == 0) {
                $person->forceDelete();
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function guardAgainstUnknownRelationType($relation)
    {
        if (!in_array($relation, $this->relationTypes)) {
            throw new InvalidRelationTypeException('invalid relation type ' . $relation);
        }
    }
}