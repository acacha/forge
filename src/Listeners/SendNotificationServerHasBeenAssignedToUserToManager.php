<?php

namespace Acacha\Forge\Listeners;

use Acacha\Forge\Notifications\ServerPermissionRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SentNotificationServerHasBeenAssignedToUserToManager.
 *
 * @package App\Listeners
 */
class SendNotificationServerHasBeenAssignedToUserToManager
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        resolve(\Illuminate\Notifications\ChannelManager::class)
            ->send(null, new ServerPermissionRequested($event->server));
    }
}
