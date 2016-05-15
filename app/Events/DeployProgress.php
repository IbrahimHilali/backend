<?php

namespace App\Events;

use App\Events\Event;
use Grimm\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeployProgress extends Event implements ShouldBroadcast
{

    use SerializesModels;

    /**
     * @var string
     */
    public $type;
    /**
     * @var int
     */
    public $amount;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param integer $amount
     * @param string  $type
     * @param User    $user
     */
    public function __construct($amount, $type, User $user)
    {
        $this->amount = $amount;
        $this->type = $type;
        $this->user = $user;
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
            'amount' => $this->amount,
            'type' => $this->type
        ];
    }

    public function onQueue()
    {
        return 'event-queue';
    }
}
