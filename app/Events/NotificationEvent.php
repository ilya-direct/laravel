<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $page;
    
    /**
     * NotificationEvent constructor.
     *
     * @param $page
     */
    public function __construct()
    {
        $this->page = 2;
    }
}
