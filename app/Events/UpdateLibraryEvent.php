<?php

namespace App\Events;

use Grimm\LibraryBook;
use Grimm\User;
use Illuminate\Queue\SerializesModels;

class UpdateLibraryEvent extends Event
{

    use SerializesModels;

    /**
     * @var LibraryBook
     */
    public $book;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param LibraryBook $book
     * @param User $user
     */
    public function __construct(LibraryBook $book, User $user)
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
