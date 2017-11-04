<?php

namespace Acacha\Forge\Models;

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
    protected $fillable = ['user_id','forge_id','state'];

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
     * Get the user that owns the server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
