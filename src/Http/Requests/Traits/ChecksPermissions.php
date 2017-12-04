<?php

namespace Acacha\Forge\Http\Requests\Traits;
use Auth;

/**
 * Trait ChecksPermissions.
 *
 * @package Acacha\Events\Http\Requests\Traits
 */
trait ChecksPermissions
{
    /**
     * Logged as permission to.
     *
     * @param $permission
     * @return bool
     */
    protected function hasPermissionTo($permission)
    {
        if (Auth::user()->hasPermissionTo($permission)) return true;
        return false;
    }

    /**
     * Owns model.
     *
     * @param $model
     * @return bool
     */
    protected function owns($model,$field = 'user_id')
    {
        if (Auth::user()->id == $this->$model->$field) return true;
        return false;
    }
}