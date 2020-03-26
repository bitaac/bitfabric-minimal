<?php

namespace Bitaac\Admin\Http\Controllers\Account;

use Illuminate\Http\Request;
use Bitaac\Contracts\Account;
use Bitaac\Laravel\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * [GET] /admin/account/{account}
     *
     * @param  \Bitaac\Contracts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function get(Account $account)
    {
        return view('admin::account.index')->with([
            'editAccount' => $account,
        ]);
    }

    /**
     * [POST] /admin/account/{account}
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Bitaac\Contracts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, Account $account)
    {
        if (! $request->has('admin')) {
            $request->merge(['admin' => false]);
        }

        $account->bitaac->update($request->only([
            'points', 'admin'
        ]));

        return back()->with([
            'success' => 'Your changes has been saved.',
        ]);
    }
}
