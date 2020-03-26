<?php

namespace Bitaac\Contracts\Forum;

interface Board
{
    /**
     * Retrive all threads that belongs to board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads();
}
