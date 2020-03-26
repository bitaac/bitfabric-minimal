<?php

namespace Bitaac\Guild\Http\Controllers\Guild\Member;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\Member\CancelRequest;

class CancelController extends Controller
{
    /**
     * Show the cancel form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.member.cancel')->with(compact('guild'));
    }

    /**
     * Process the cancel.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(CancelRequest $request, $guild)
    {
        $invite = app('guild.invite')->where(function ($query) use ($request, $guild) {
            $query->where('player_id', $request->get('character'));
            $query->where('guild_id', $guild->id);
        });

        $invite->delete();

        return redirect($guild->link())->withSuccess(trans('guild.invite.cancel.success'));
    }
}
