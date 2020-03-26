<?php

namespace Bitaac\Forum\Models;

use Bitaac\Traits\SlugAble;
use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\Forum\Board as Contract;

class Board extends Model implements Contract
{
    use SlugAble;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '__bitaac_forum_boards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'order', 'description'];

    /**
     * Retrive all threads that belongs to board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany('Bitaac\Contracts\Forum\Post', 'board_id')->where('belongs_to', 0)->orderBy('timestamp', 'desc');
    }

    /**
     * Retrive board latest post info.
     *
     * @return \Bitaac\Contracts\Forum\Post
     */
    public function latest()
    {
        return $this->hasMany('Bitaac\Contracts\Forum\Post', 'board_id')->orderBy('created_at', 'desc')->first();
    }

    /**
     * Create a link to the board.
     *
     * @return string
     */
    public function link()
    {
        return route('forum.board', $this);
    }

    /**
     * Retrive all replies that belongs to board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('Bitaac\Contracts\Forum\Post', 'board_id')->where('belongs_to', '>', 0);
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
     * Set the forum board slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->createSlug($value);
    }
}
