<?php

namespace Bitaac\Player\Traits;

trait Storage 
{
    /**
     * Set a storage key & value.
     *
     * @param integer  $key
     * @param integer  $value
     * @return void
     */
    public function setStorageValue($key, $value)
    {
        if (! $this->hasStorage($key)) {
            $storage = app('player.storage');
            $storage->player_id = $this->id;
        } else {
            $storage = $this->getStorage($key);  
        }

        $storage->key = $key;
        $storage->value = $value;
        $storage->save();

        return $storage;
    }

    /**
     * Get the storage.
     *
     * @param  integer  $key
     * @return PlayerStorage|null
     */
    public function getStorage($key)
    {
        $storage = $this->storage()->where('key', $key);

        return ($storage->exists()) ? $storage->first() : null ;
    }

    /**
     * Determine if player has storage.
     *
     * @param  integer  $key
     * @return boolean
     */
    public function hasStorage($key)
    {
        return $this->storage()->where('key', $key)->exists();
    }

    /**
     * Get a storage key value.
     *
     * @param  integer  $key
     * @param  integer  $default
     * @return integer
     */
    public function getStorageValue($key, $default = null)
    {
        if (! $this->hasStorage($key)) {
            return (! is_null($default)) ? $default : 0 ;
        }

        return $this->getStorage($key)->value;
    }
}