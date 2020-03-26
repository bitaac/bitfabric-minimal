<?php

namespace Bitaac\Guild\Http\Controllers\Guild;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\Rank\EditRequest;

class RankController extends Controller
{
    /**
     * Show the ranks edit page to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.rank.edit')->with(compact('guild'));
    }

    /**
     * Process the rank edition.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(EditRequest $request, $guild)
    {
        $rank = app('guild.rank')->find($request->get('rank'));

        if (is_null($rank) and $rank->guild_id != $guild->id) {
            return back()->withError(trans('guild.edit.ranks.fail'));
        }

        $rank->name = $request->get('name');
        $rank->save();

        return back()->withSuccess(trans('guild.edit.ranks.success'));
    }
}
