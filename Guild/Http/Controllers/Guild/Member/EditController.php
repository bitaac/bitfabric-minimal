<?php

namespace Bitaac\Guild\Http\Controllers\Guild\Member;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\Member\EditRequest;

class EditController extends Controller
{
    /**
     * Show the member edit form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.member.edit')->with(compact('guild'));
    }

    /**
     * Process the member edition.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(EditRequest $request, $guild)
    {
        $rank = app('guild.rank')->find($request->get('rank'));
        $member = app('guild.member')->find($request->get('member'));

        if (is_null($rank) or is_null($member) or $rank->guild_id != $guild->id or $member->guild_id != $guild->id) {
            return back()->withError(trans('guild.members.edit.fail'));
        }

        $member->rank_id = $rank->id;

        $member->save();

        return back()->withSuccess(trans('guild.members.edit.success'));
    }
}
