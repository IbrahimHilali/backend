<?php

namespace App\Events;

use App\Events\Event;
use Grimm\Book;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StoreBookEvent extends Event
{
    use SerializesModels;
    /**
     * @var Book
     */
    public $book;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Book $book
     * @param User $user
     */
    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
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
