<?php

namespace Bitaac\Account\Http\Controllers\Character;

use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Bitaac\Account\Http\Requests\Character\CreateRequest;

class CreateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->middleware(['auth']);

        $this->auth = $auth;
    }

    /**
     * Show the create character page.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('account.character.create');
    }

    /**
     * Handle the create character request.
     *
     * @param  \Bitaac\Account\Http\Requests\Character\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(CreateRequest $request)
    {
        if ($this->auth->user()->characters()->count() >= config('bitaac.account.max-characters')) {
            return back()->withError('You have already reached maximum characters per account.');
        }

        app('player')->make($request->all());

        return redirect()->route('account')->with([
            'success' => 'Your character has been created.',
        ]);
    }
}
