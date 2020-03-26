<?php

namespace Bitaac\Contracts\Forum;

interface Post
{
    /**
     * Lock the post.
     *
     * @return void
     */
    public function lock();
}
