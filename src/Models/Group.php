<?php

namespace Acacha\Forge\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group.
 *
 * @package Acacha\Forge\Models
 */
class Group extends Model
{
    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get all of the users that are assigned this group.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'groupable');
    }
}
