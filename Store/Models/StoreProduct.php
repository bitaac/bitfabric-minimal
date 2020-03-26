<?php

namespace Bitaac\Store\Models;

use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\StoreProduct as Contract;

class StoreProduct extends Model implements Contract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'item_id', 'count', 'points', 'description'];

    protected $table = '__bitaac_store_products';

    public function imageIsLink()
    {
        return (bool) filter_var($this->image, FILTER_VALIDATE_URL);
    }

    public function getItemImage()
    {
        return str_replace('{item_id}', $this->item_id, config('bitaac.app.item_images'));
    }
}
