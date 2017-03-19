<?php

namespace App\Library\Services;

use Grimm\LibraryBook;
use Grimm\LibraryPerson;

class LibraryRelationService
{

    /**
     * @param LibraryBook $book
     * @param $relation
     * @param LibraryPerson $person
     * @return bool
     */
    public function store(LibraryBook $book, $relation, LibraryPerson $person)
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany $relationQuery */
        $relationQuery = $book->{str_plural($relation)}();

        try {
            $relationQuery->save($person);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}