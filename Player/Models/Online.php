<?php

namespace Bitaac\Player\Models;

use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\Online as Contract;

class Online extends Model implements Contract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players_online';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
