<?php

namespace App\Events;

use Grimm\LibraryPerson;
use Grimm\User;
use Illuminate\Queue\SerializesModels;

class StoreLibraryPersonEvent extends Event
{

    use SerializesModels;

    /**
     * @var LibraryPerson
     */
    public $person;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param LibraryPerson $person
     * @param User $user
     */
    public function __construct(LibraryPerson $person, User $user)
    {
        $this->person = $person;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
