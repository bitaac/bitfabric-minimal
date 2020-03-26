<?php

namespace Bitaac\Account\Http\Controllers;

use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class LogoutController extends Controller
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
     * Show the logout page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.logout');
    }

    /**
     * Handle the logout request.
     *
     * @return \Illuminate\Http\Response
     */
    public function post()
    {
        $this->auth->logout();

        return redirect()->route('index')->with([
            'success' => 'You have successfully logged out from your account.',
        ]);
    }
}
