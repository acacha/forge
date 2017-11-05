<?php

namespace Acacha\Forge\Models\Traits;

use Acacha\Forge\Models\Server;

/**
 * Class HasServers.
 *
 * @package Acacha\Forge\Models
 */
trait HasServers
{
    /**
     * Get the user servers.
     */
    public function servers()
    {
        return $this->hasMany(Server::class);
    }
}
