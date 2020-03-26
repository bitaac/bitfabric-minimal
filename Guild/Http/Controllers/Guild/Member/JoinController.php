<?php

namespace Bitaac\Guild\Http\Controllers\Guild\Member;

use Auth;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\Member\JoinRequest;

class JoinController extends Controller
{
    /**
     * Show the join form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        $invites = $guild->getInvites->reject(function ($value, $key) use ($guild) {
            return $value->guild_id != $guild->id or $value->player->account_id != Auth::id();
        });

        return view('guilds.guild.member.join')->with(compact('guild', 'invites'));
    }

    /**
     * Process the join.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(JoinRequest $request, $guild)
    {
        $member = app('guild.member');
        $member->player_id = (int) $request->get('character');
        $member->guild_id = $guild->id;
        $member->rank_id = app('guild.rank')->where(function ($query) use ($guild) {
            $query->where('guild_id', $guild->id);
            $query->where('level', 1);
        })->first()->id;
        $member->save();

        $deletion = app('guild.invite')->where(function ($query) use ($member) {
            $query->where('player_id', $member->player_id);
            $query->where('guild_id', $member->guild_id);
        })->delete();

        return redirect($guild->link())->withSuccess(trans('guild.join.success'));
    }
}
