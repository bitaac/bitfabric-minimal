<?php

namespace Bitaac\Admin\Http\Controllers\Account;

use Illuminate\Http\Request;
use Bitaac\Contracts\Account;
use Bitaac\Laravel\Http\Controllers\Controller;

class DeleteController extends Controller
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
     * [GET] /admin/account/{account}/delete
     *
     * @param  \Bitaac\Contracts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function get(Account $account)
    {
        return view('admin::account.delete')->with([
            'editAccount' => $account,
        ]);
    }

    /**
     * [POST] /admin/account/{account}/delete
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Bitaac\Contracts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, Account $account)
    {
        if ($request->has('characters')) {
            $account->characters()->delete();
        }

        $account->delete();

        return redirect()->route('admin.accounts')->with([
            'success' => 'Account has been deleted.',
        ]);
    }
}
