<?php

namespace Bitaac\Account\Http\Controllers\Change;

use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Bitaac\Account\Http\Requests\Change\PasswordRequest;

class PasswordController extends Controller
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
     * Show the change password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('account.change.password');
    }

    /**
     * Handle the change password request.
     *
     * @param  \Bitaac\Account\Http\Requests\Change\PasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(PasswordRequest $request)
    {
        $user = $this->auth->user();

        if (! $this->auth->validate(['name' => $user->name, 'password' => $request->get('current')])) {
            return back()->withErrors([
                'error' => 'Current password do not match.',
            ])->withInput();
        }

        $user->update($request->only([
            'password'
        ]));

        return back()->with([
            'success' => 'Your password has been updated.',
        ]);
    }
}
