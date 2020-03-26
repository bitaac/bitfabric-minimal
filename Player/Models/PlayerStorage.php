<?php

namespace Bitaac\Player\Models;

use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\PlayerStorage as Contract;

class PlayerStorage extends Model implements Contract
{
    /**
     * Set the primary key.
     */
    protected $primaryKey = 'player_id';

    /**
     * Table used by the model.
     */
    protected $table = 'player_storage';

    /**
     * Tell the model to not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;
}
