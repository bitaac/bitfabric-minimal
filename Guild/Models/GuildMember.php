<?php

namespace Bitaac\Guild\Models;

use Bitaac\Core\Database\Eloquent\Model;

class GuildMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guild_membership';

    /**
     * Tell the model to ignore timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'player_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the player.
     *
     * @return Player
     */
    public function player()
    {
        return $this->hasOne('Bitaac\Contracts\Player', 'id', 'player_id');
    }

    /**
     * Get the player rank.
     *
     * @return string
     */
    public function rank()
    {
        return $this->hasOne('Bitaac\Contracts\GuildRank', 'id', 'rank_id');
    }

    /**
     * Get the associated guild with the player.
     *
     * @return hasOne
     */
    public function guild()
    {
        return $this->hasOne('Bitaac\Contracts\Guild', 'id', 'guild_id');
    }

    /**
     * Customize __call.
     *
     * @param mixed  $method
     * @param mixed  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this->guild, $method)) {
            return call_user_func_array([$this->guild, $method], $arguments);
        }

        if ($this->guild and $this->guild->offsetExists($method)) {
            return $this->guild->offsetGet($method);
        }

        return parent::__call($method, $arguments);
    }
}
