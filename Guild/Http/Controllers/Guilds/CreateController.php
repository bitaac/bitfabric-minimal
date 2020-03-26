<?php

namespace Bitaac\Guild\Http\Controllers\Guilds;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guilds\CreateRequest;

class CreateController extends Controller
{
    /**
     * Show the create guild form to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('guilds.create');
    }

    /**
     * Create the guild.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(CreateRequest $request)
    {
        $guild = app('guild');
        $guild->name = $request->get('name');
        $guild->ownerid = $request->get('leader');
        $guild->creationdata = time();
        $guild->slug = str_slug($request->get('name'));
        $guild->save();

        $rank = app('guild.rank')->where(function ($query) use ($guild) {
            $query->where('guild_id', $guild->id);
            $query->where('level', 3);
        })->first();

        $membership = app('guild.member');
        $membership->player_id = $request->get('leader');
        $membership->guild_id = $guild->id;
        $membership->rank_id = $rank->id;
        $membership->nick = '';
        $membership->save();

        return redirect(url_e('/guild/:name', ['name' => $request->get('name')]))
               ->withSuccess('Your guild '.$request->get('name').' has been created.');
    }
}
