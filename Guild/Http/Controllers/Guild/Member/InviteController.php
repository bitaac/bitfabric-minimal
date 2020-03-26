<?php

namespace Bitaac\Guild\Http\Controllers\Guild\Member;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\Member\InviteRequest;

class InviteController extends Controller
{
    /**
     * Show the invite form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.member.invite')->with(compact('guild'));
    }

    /**
     * Process the invitation.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(InviteRequest $request, $guild)
    {
        $character = app('player')->where('name', $request->get('character'))->first();

        // If character already has been invited to this guild.
        if ($character->guildInvitees->contains('guild_id', $guild->id)) {
            return back()->withError(trans('guild.invite.already.invited'));
        }

        // If character already member of a guild.
        if ($character->guild) {
            return back()->withError(trans('guild.invite.already.member'));
        }

        $invite = app('guild.invite');
        $invite->player_id = $character->id;
        $invite->guild_id = $guild->id;
        $invite->save();

        return back()->withSuccess(trans('guild.invite.success'));
    }
}
