<?php

namespace Bitaac\Core\Models;

use Bitaac\Core\Database\Eloquent\Model;

class Bitaac extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['terms_of_service', 'rules'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '__bitaac';
}
