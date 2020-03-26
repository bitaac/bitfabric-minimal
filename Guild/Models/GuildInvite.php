<?php

namespace Bitaac\Guild\Models;

use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\GuildInvite as Contract;

class GuildInvite extends Model implements Contract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guild_invites';

    /**
     * Tell the model to ignore timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get related player to the invite.
     *
     * @return
     */
    public function player()
    {
        return $this->hasOne('Bitaac\Contracts\Player', 'id', 'player_id');
    }
}
