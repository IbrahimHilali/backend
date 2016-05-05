<?php

namespace App\Events;

use App\Events\Event;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeploymentDone extends Event implements ShouldBroadcast
{

    use SerializesModels;

    public $user;
    /**
     * @var
     */
    public $people;
    /**
     * @var
     */
    public $books;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param      $people
     * @param      $books
     */
    public function __construct(User $user, $people, $books)
    {
        $this->user = $user;
        $this->people = $people;
        $this->books = $books;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['user.' . $this->user->id];
    }

    public function broadcastWith()
    {
        return [
            'book' => $this->books,
            'people' => $this->people,
        ];
    }

    public function onQueue()
    {
        return 'event-queue';
    }
}
