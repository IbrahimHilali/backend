<?php

use Grimm\Person;
use Illuminate\Support\Str;

class PersonTest extends TestCase
{

    /**
     * @test
     */
    public function a_person_can_be_scoped_by_letters()
    {
        foreach (Person::byLetter('a')->get() as $person) {
            $this->assertTrue(Str::startsWith(Str::lower($person->last_name), ['a', 'ä']));
        }
    }
}
