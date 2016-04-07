<?php

namespace App\Events;

use App\Events\Event;
use Grimm\Person;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StorePersonEvent extends Event
{
    use SerializesModels;
    /**
     * @var Person
     */
    public $person;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Person $person
     * @param User $user
     */
    public function __construct(Person $person, User $user)
    {
        //
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
