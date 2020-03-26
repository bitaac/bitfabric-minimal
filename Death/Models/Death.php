<?php

namespace Bitaac\Death\Models;

use Bitaac\Contracts\Death as Contract;
use Bitaac\Core\Database\Eloquent\Model;

class Death extends Model implements Contract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_deaths';

    /**
     * Get the related player.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function player()
    {
        return $this->hasOne('Bitaac\Contracts\Player', 'id', 'player_id');
    }
}
