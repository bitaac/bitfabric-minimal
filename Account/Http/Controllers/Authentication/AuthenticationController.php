<?php

namespace Bitaac\Account\Http\Controllers\Authentication;

use Bitaac;
use Google2FA;
use Illuminate\Http\Request;
use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;

class AuthenticationController extends Controller
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

        $this->middleware(function ($request, $next) {
            if (Bitaac::twofa()->disabled()) {
                return redirect()->route('account');
            }

            return $next($request);
        });
    }

    /**
     * Show the authentication page to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        $account = $this->auth->user();

        $secret = $account->secret ? $account->secret : Google2FA::generateSecretKey();

        $google2fa_url = Google2FA::getQRCodeGoogleUrl(
            'bitaac',
            $account->name,
            $account->bitaac->secret
        );

        return view('account.authentication.index')->with([
            'google2fa_url' => $google2fa_url,
        ]);
    }

    /**
     * Update the two-factor authentication.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        $this->validate($request, [
            'secret' => ['required'],
        ]);

        $user = auth()->user();
        $secret = $request->get('secret');

        try {
            $valid = \Google2FA::verifyKey($user->bitaac->secret, $secret);
        } catch (InvalidCharactersException $e) {
            return back()->withErrors([
                'secret' => 'Invalid secret key.',
            ]);
        }

        if (! $valid) {
            return back()->withError(trans('authentication.not.valid'));
        }

        if ($user->secret) {
            $user->secret = '';
            $user->save();

            return back()->withSuccess(trans('authentication.disable.success'));
        } else {
            $user->secret = $user->bitaac->secret;
            $user->save();

            return back()->withSuccess(trans('authentication.enable.success'));
        }
    }
}
