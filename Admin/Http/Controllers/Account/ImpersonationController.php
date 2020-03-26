<?php

namespace Bitaac\Admin\Http\Controllers\Account;

use Illuminate\Http\Request;
use Bitaac\Contracts\Account;
use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('admin')->except('stopImpersonating');
    }

    /**
     * Impersonate the given user.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Bitaac\Contracts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function impersonate(Request $request, Account $account)
    {
        $request->session()->flush();

        // We will store the original user's ID in the session so we can remember who we
        // actually are when we need to stop impersonating the other user, which will
        // allow us to pull the original user back out of the database when needed.
        $request->session()->put(
            'bitaac:impersonator', $request->user()->id
        );

        Auth::login($account);

        return redirect()->route('index');
    }

    /**
     * Stop impersonating and switch back to primary account.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Bitaac\Contracts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function stopImpersonating(Request $request, Account $account)
    {
        $currentId = Auth::id();

        // We will make sure we have an impersonator's user ID in the session and if the
        // value doesn't exist in the session we will log this user out of the system
        // since they aren't really impersonating anyone and manually hit this URL.
        if (! $request->session()->has('bitaac:impersonator')) {
            Auth::logout();

            return redirect()->route('index');
        }

        $userId = $request->session()->pull(
            'bitaac:impersonator'
        );

        // After removing the impersonator user's ID from the session so we can retrieve
        // the original user. Then, we will flush the entire session to clear out any
        // stale data from while we were doing the impersonation of the other user.
        $request->session()->flush();

        Auth::loginUsingId($userId);

        return redirect()->route('admin.account', $account);
    }
}
