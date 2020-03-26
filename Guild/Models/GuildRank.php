<?php

namespace Bitaac\Guild\Models;

use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\GuildRank as Contract;

class GuildRank extends Model implements Contract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guild_ranks';

    /**
     * Tell the model to ignore timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the guild players that match rank.
     *
     * @return
     */
    public function getMembers()
    {
        return $this->hasMany('Bitaac\Contracts\GuildMember', 'rank_id')->where('guild_id', $this->guild_id);
    }
}
