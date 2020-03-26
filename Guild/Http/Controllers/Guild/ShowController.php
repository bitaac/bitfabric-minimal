<?php

namespace Bitaac\Guild\Http\Controllers\Guild;

use Bitaac\Laravel\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Show the guild to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($guild)
    {
        $account = auth()->user();

        return view('guilds.guild.show')->with([
            'guild' => $guild,
            'hasLeader' => $account and $account->hasLeader($guild),
            'hasOwner' => $account and $account->hasOwner($guild),
            'hasViceLeader' => $account and $account->hasViceLeader($guild),
            'hasMember' => $account and $account->hasMember($guild),
            'hasInvite' => $account and $account->hasGuildInvite($guild),
            'auth' => auth()->check(),
        ]);
    }
}
