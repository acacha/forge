<?php

namespace Acacha\Forge\Models\Traits;

use Acacha\Forge\Models\Assignment;

/**
 * Class HasAssignments.
 *
 * @package Acacha\Forge\Models
 */
trait HasAssignments
{
    /**
     * Get the user servers.
     */
    public function assignments()
    {
        return $this->morphToMany(Assignment::class,'assignable');
    }
}
