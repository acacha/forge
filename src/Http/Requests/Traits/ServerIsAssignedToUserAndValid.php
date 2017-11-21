<?php

namespace Acacha\Forge\Http\Requests\Traits;

use Auth;

/**
 * Trait ServerIsAssignedToUserAndValid.
 *
 * @package Acacha\Forge\Http\Requests
 */
trait ServerIsAssignedToUserAndValid
{
    /**
     * Is server assigned to user and valid?
     *
     * @param $serverId
     * @return bool
     */
    protected function isServerAssignedToUserAndValid($serverId)
    {
        return in_array($serverId, Auth::user()->servers()->valid()->get()->pluck('forge_id')->toArray());
    }

}