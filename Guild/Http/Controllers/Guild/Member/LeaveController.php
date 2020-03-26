<?php

namespace Bitaac\Guild\Http\Controllers\Guild\Member;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\Member\LeaveRequest;

class LeaveController extends Controller
{
    /**
     * Show the leave form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.member.leave')->with(compact('guild'));
    }

    /**
     * Process the leave.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(LeaveRequest $request, $guild)
    {
        $member = app('guild.member')->where(function ($query) use ($guild, $request) {
            $query->where('player_id', $request->get('character'));
            $query->where('guild_id', $guild->id);
        })->delete();

        return redirect($guild->link())->withSuccess(trans('guild.invite.leave.success'));
    }
}
