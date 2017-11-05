<?php

namespace Acacha\Forge\Events;

use Acacha\Forge\Models\Server;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class ServerRequestPermissionHasBeenAsked.
 *
 * @package Acacha\Forge
 */
class ServerRequestPermissionHasBeenAsked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The server that has been assigned to user.
     *
     * @var
     */
    public $server;

    /**
     * Create a new event instance.
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
