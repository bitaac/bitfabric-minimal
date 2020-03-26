<?php

namespace Bitaac\Guild\Http\Controllers\Guild;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\DisbandRequest;

class DisbandController extends Controller
{
    /**
     * Show the disband guild form to the user.
     *
     * @param \Bitaac\Guild\Models\Guild  $guild
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.disband')->with(compact('guild'));
    }

    /**
     * Process the disband.
     *
     * @param \Bitaac\Guild\Http\Requests\Guild\DisbandRequest  $request
     * @param \Bitaac\Guild\Models\Guild  $guild
     * @return \Illuminate\Http\Response
     */
    public function post(DisbandRequest $request, $guild)
    {
        $auth = auth();

        if (! $auth->validate(['name' => $auth->user()->name, 'password' => $request->get('password')])) {
            return back()->withError(trans('guild.disband.password.fail'));
        }

        $guild->getInvites()->delete();
        $guild->getMembers()->delete();
        $guild->delete();

        return redirect('/account')->withSuccess(trans('guild.disband.success'));
    }
}
