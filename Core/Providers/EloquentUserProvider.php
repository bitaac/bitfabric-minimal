<?php

namespace Bitaac\Core\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class EloquentUserProvider extends UserProvider
{
    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        return resolve($this->model);
    }
}
