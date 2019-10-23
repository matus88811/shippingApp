<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attributesFromEmail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributesFromEmail = $attributes; // len na prenesenie dat a ich prijatie bude v listener handleri
    }

  
}
