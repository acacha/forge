<?php

namespace Acacha\Forge\Models;

use Acacha\Forge\Models\Scopes\ValidScope;
use Acacha\Stateful\Contracts\Stateful;
use Acacha\Stateful\Traits\StatefulTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server.
 *
 * @package Acacha\Forge\Models
 */
class Server extends Model implements Stateful
{
    use StatefulTrait;

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = ['name','user_id','forge_id','state','ipAddress'];

    /**
     * Hidden.
     *
     * @var array
     */
    protected $hidden = ['token'];

    /**
     * Transaction States
     *
     * @var array
     */
    protected $states = [
        'pending' => ['initial' => true],
        'valid' => ['final' => true]
    ];

    /**
     * Transaction State Transitions
     *
     * @var array
     */
    protected $transitions = [
        'validate' => [
            'from' => ['pending'],
            'to' => 'valid'
        ],
        'unvalidate' => [
            'from' => ['valid'],
            'to' => 'pending'
        ]
    ];

    /**
     * Scope a query to only include valid servers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid($query)
    {
        return $query->where('state', 'valid');
    }

    /**
     * Get the user that owns the server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
