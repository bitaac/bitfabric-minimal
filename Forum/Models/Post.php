<?php

namespace Bitaac\Forum\Models;

use Bitaac\Traits\SlugAble;
use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\Forum\Post as Contract;

class Post extends Model implements Contract
{
    use SlugAble;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '__bitaac_forum_posts';

    /**
     * Get the player associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function player()
    {
        return $this->hasOne('Bitaac\Player\Models\Player', 'id', 'player_id');
    }

    /**
     * Get the forum board associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function board()
    {
        return $this->hasOne('Bitaac\Forum\Models\Board', 'id', 'board_id');
    }

    /**
     * Lock the post.
     *
     * @return void
     */
    public function lock()
    {
        $this->locked = 1;
        $this->save();
    }

    /**
     * Unlock the post.
     *
     * @return void
     */
    public function unlock()
    {
        $this->locked = 0;
        $this->save();
    }

    /**
     * Get the replies associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('Bitaac\Forum\Models\Post', 'belongs_to')->join('players', function ($join) {
            $join->on('__bitaac_forum_posts.player_id', '=', 'players.id');
        })->select([
            '__bitaac_forum_posts.id', 'players.name AS player_name', 'content', 'timestamp', 'player_id', 'created_at', 'board_id',
        ]);
    }

    /**
     * Get the full link to thread.
     *
     * @return string
     */
    public function link()
    {
        return route('forum.thread', [$this->board, $this]);
    }

    /**
     * Get the full hotlink to thread reply.
     *
     * @param  \Bitaac\Contracts\Forum\Post  $reply
     * @return string
     */
    public function hotlink($reply)
    {
        return route('forum.thread.hotlink', [$this->board, $this, $reply->id]);
    }

    /**
     * Delete all replies associated with the post.
     *
     * @return void
     */
    public function deleteReplies()
    {
        $posts = $this->where('belongs_to', $this->id)->delete();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Determine if post is locked.
     *
     * @return boolean
     */
    public function isLocked()
    {
        return (boolean) $this->locked;
    }

    /**
     * Set the forum post slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->createSlug($value);
    }
}
