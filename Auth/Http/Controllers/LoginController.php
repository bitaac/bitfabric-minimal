<?php

namespace Bitaac\Auth\Http\Controllers;

use Bitaac;
use Google2FA;
use Illuminate\Contracts\Auth\Guard;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Auth\Http\Requests\LoginRequest;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;

class LoginController extends Controller
{
    /**
     * Create a new login controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->middleware(['guest']);

        $this->auth = $auth;
    }

    /**
     * Show the login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     *
     * @param  \Bitaac\Account\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(LoginRequest $request)
    {
        $user = app('account')->where(function ($query) use ($request) {
            $query->where(Bitaac::getAccountNameField(), $request->get('account'));
            $query->where(Bitaac::getAccountPasswordField(), bcrypt($request->get('password')));
        });

        if (! $user->exists()) {
            return back()->withErrors([
                'error' => 'These credentials do not match our records.',
            ]);
        }

        $user = $user->first();

        if ($user->secret && Bitaac::twofa()->enabled()) {
            if (! $request->filled('2fa')) {
                return back()->withError(trans('auth.login.2fa.required'));
            }

            if (! $this->verify2FA($user->secret, $request->get('2fa'))) {
                return back()->withError(trans('auth.login.2fa.not.valid'));
            }
        }

        $user->bitaac->updateLastLogin();
        $this->auth->loginUsingId($user->id);

        return redirect()->route('account')->with([
            'success' => 'You have been logged in.',
        ]);
    }

    /**
     * Verify the two-factor authentication key.
     *
     * @param  string  $secret
     * @param  string  $key
     * @return void
     */
    public function verify2FA($secret, $key)
    {
        try {
            $valid = Google2FA::verifyKey($secret, $key);
        } catch (SecretKeyTooShortException $e) {
            $valid = false;
        }

        return $valid;
    }
}
