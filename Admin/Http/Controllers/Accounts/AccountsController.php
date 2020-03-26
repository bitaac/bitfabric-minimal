<?php

namespace Bitaac\Admin\Http\Controllers\Accounts;

use Bitaac\Contracts\Account;
use Bitaac\Laravel\Http\Controllers\Controller;

class AccountsController extends Controller
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
     * [GET] /admin/accounts
     *
     * @param  \Bitaac\Contracts\Account  $product
     * @return \Illuminate\Http\Response
     */
    public function get(Account $account)
    {
        return view('admin::accounts.index')->with([
            'accounts' => $account->all(),
        ]);
    }
}
