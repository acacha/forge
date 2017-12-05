<?php

namespace Acacha\Forge\Models;

use Acacha\Forge\Models\Group;
use Acacha\Stateful\Contracts\Stateful;
use Acacha\Stateful\Traits\StatefulTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Assignment.
 *
 * @package Acacha\Forge\Models
 */
class Assignment extends Model implements Stateful
{
    use StatefulTrait;

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = ['name','repository_uri','repository_type','forge_site','forge_server'];

    /**
     * Transaction States
     *
     * @var array
     */
    protected $states = [
        'pending' => ['initial' => true],
        'assigned',
        'closed' => ['final' => true]
    ];

    /**
     * Transaction State Transitions
     *
     * @var array
     */
    protected $transitions = [
        'assign' => [
            'from' => ['pending'],
            'to' => 'assigned'
        ],
        'close' => [
            'from' => ['pending','assigned'],
            'to' => 'closed'
        ]
    ];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'assignable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'assignable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function assignators()
    {
        return $this->morphedByMany(User::class, 'assignator')->withTimestamps();
    }
}
