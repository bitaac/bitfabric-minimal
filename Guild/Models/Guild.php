<?php

namespace Bitaac\Guild\Models;

use Bitaac\Contracts\Guild as Contract;
use Bitaac\Core\Database\Eloquent\Model;

class Guild extends Model implements Contract
{
    /**
     * Tell the model what table to use.
     *
     * @var string
     */
    protected $table = 'guilds';

    /**
     * Turn off timestamps for model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the BitGuild associated with the current guild.
     *
     * @return BitGuild
     */
    public function bitaac()
    {
        return $this->hasOne('Bitaac\Guild\Models\BitGuild', 'guild_id');
    }

    /**
     * Get the guild logo link.
     *
     * @return string
     */
    public function logoLink()
    {
        return route('guild.logo', $this);
    }

    /**
     * Get a link to the guild.
     *
     * @return string
     */
    public function link()
    {
        return route('guild', $this);
    }

    /**
     * Get members.
     *
     * @return
     */
    public function getMembers()
    {
        return $this->hasMany('Bitaac\Contracts\GuildMember', 'guild_id');
    }

    /**
     * Get guild leaders.
     *
     * @return
     */
    public function getLeaders()
    {
        return $this->hasManyThrough('Bitaac\Contracts\GuildMember', 'Bitaac\Contracts\GuildRank', 'guild_id', 'rank_id')->where('level', 3);
    }

    /**
     * Get vice leaders.
     *
     * @return
     */
    public function getViceLeaders()
    {
        return $this->hasManyThrough('Bitaac\Contracts\GuildMember', 'Bitaac\Contracts\GuildRank', 'guild_id', 'rank_id')->where('level', 2);
    }

    /**
     * Get all members.
     *
     * @return
     */
    public function getAllMembers()
    {
        return $this->hasMany('Bitaac\Contracts\GuildMember', 'guild_id');
    }

    /**
     * Get guild ranks.
     *
     * @return
     */
    public function getRanks()
    {
        return $this->hasMany('Bitaac\Contracts\GuildRank', 'guild_id');
    }

    /**
     * Get guild invites.
     *
     * @return
     */
    public function getInvites()
    {
        return $this->hasMany('Bitaac\Contracts\GuildInvite', 'guild_id');
    }

    /**
     * Get members except owner.
     *
     * @return
     */
    public function getMembersExceptOwner()
    {
        return $this->getMembers()->where('player_id', '!=', $this->ownerid);
    }

    /**
     * Changing an Eloquent model's "route key".
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
