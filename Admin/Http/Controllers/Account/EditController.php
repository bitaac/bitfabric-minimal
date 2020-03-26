<?php

namespace Bitaac\Admin\Http\Controllers\Account;

use Bitaac\Contracts\Account;
use Bitaac\Laravel\Http\Controllers\Controller;
use Bitaac\Admin\Http\Requests\Accounts\EditRequest;

class EditController extends Controller
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
        return view('admin::account.edit')->with([
            'editAccount' => $account,
        ]);
    }

    /**
     * [POST] /admin/account/{account}
     *
     * @param  \Bitaac\Admin\Http\Requests\Accounts\EditRequest  $request
     * @param  \Bitaac\Contracts\Account                         $account
     * @return \Illuminate\Http\Response
     */
    public function post(EditRequest $request, Account $account)
    {
        $account->update($request->only([
            'name', 'secret', 'type', 'premdays', 'lastday', 'email'
        ]));

        return redirect()->route('admin.account.edit', $account)->with([
            'success' => 'Your changes has been saved.',
        ]);
    }
}
