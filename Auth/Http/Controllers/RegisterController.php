<?php

namespace Bitaac\Auth\Http\Controllers;

use Bitaac;
use Illuminate\Contracts\Auth\Guard;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Auth\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Create a new register controller instance.
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
     * Show the register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('auth.register');
    }

    /**
     * Handle the register request.
     *
     * @param  \Bitaac\Account\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(RegisterRequest $request)
    {
        $data = $request->only([
            'email', 'password'
        ]);

        if ($creation = Bitaac::getAccountCreationField()) {
            $data = array_merge($data, [$creation => time()]);
        }

        $account = app('account')->create(array_merge($data, [
            Bitaac::getAccountNameField() => $request->name,
        ]));

        $this->auth->login($account);

        $bitaac = $account->bitaac;
        $bitaac->updateLastLogin();

        if (Bitaac::twofa()->enabled()) {
            $bitaac->generateSecret();
        }

        return redirect()->route('account')->with([
            'success' => 'Your account has successfully been created.',
        ]);
    }
}
