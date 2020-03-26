<?php

namespace Bitaac\Account\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class AccountController extends Controller
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
     * Show the account index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.dashboard');
    }

    /**
     * Handle the logout request.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->auth->logout();

        return redirect()->route('index')->with([
            'success' => 'You have successfully logged out from your account.',
        ]);
    }
}
