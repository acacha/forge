<?php

namespace Acacha\Forge\Models\Traits;

use Acacha\Forge\Models\Assignment;

/**
 * Class HasCreatedAssignments.
 *
 * @package Acacha\Forge\Models
 */
trait HasCreatedAssignments
{
    /**
     * Get the user servers.
     */
    public function createdAssignments()
    {
        return $this->morphToMany(Assignment::class,'assignator');
    }
}
