<?php

namespace Bitaac\Guild\Http\Controllers\Guild;

use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Guild\Http\Requests\Guild\EditRequest;

class EditController extends Controller
{
    /**
     * Show the edit guild form to the user.
     *
     * @param  \Bitaac\Guild\Models\Guild  $guild
     * @return \Illuminate\Http\Response
     */
    public function form($guild)
    {
        return view('guilds.guild.edit')->with(compact('guild'));
    }

    /**
     * Process the edition.
     *
     * @param  \Bitaac\Guild\Http\Requests\Guild\EditRequest $request
     * @param  \Bitaac\Guild\Models\Guild                    $guild
     * @return \Illuminate\Http\Response
     */
    public function post(EditRequest $request, $guild)
    {
        if ($request->has('description')) {
            $guild->bitaac->description = $request->get('description');
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $guild->bitaac->logo = public_path("guild_avatars/{$guild->id}.gif");
            $file->move(public_path('guild_avatars'), "{$guild->id}.gif");
        }

        $guild->bitaac->save();

        return back()->withSuccess('Your changes were saved.');
    }

    /**
     * Delete current logo.
     *
     * @param  \Bitaac\Guild\Models\Guild  $guild
     * @return \Illuminate\Http\Response
     */
    public function deletelogo($guild)
    {
        app('files')->delete($guild->bitaac->logo);

        $guild->bitaac->logo = null;

        $guild->bitaac->save();

        return redirect("{$guild->link()}/edit");
    }
}
