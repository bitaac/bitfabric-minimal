<?php

namespace Bitaac\Guild\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;

class ShowController extends Controller
{
    /**
     * Holds the filesystem implementation.
     *
     * @var
     */
    protected $filesystem;

    /**
     * Create a new show controller instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Display the guild logo.
     *
     * @param  GET /guilds/{guild}/logo
     * @return
     */
    public function logo($guild)
    {
        $path = public_path("guild_avatars/{$guild->id}.gif");

        if (! $this->filesystem->exists($path)) {
            return redirect('/guilds');
        }

        $response = response($this->filesystem->get($path), 200);
        $response->header('Content-Type', 'image/gif');
        $response->header('Cache-Control', 'max-age=2592000');

        return $response;
    }
}
