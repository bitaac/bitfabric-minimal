<?php

namespace Bitaac\Account\Http\Controllers\Change;

use Carbon\Carbon;
use Bitaac\Laravel\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Bitaac\Account\Http\Requests\Change\EmailRequest;

class EmailController extends Controller
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
     * Show the change email page.
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        return view('account.change.email');
    }

    /**
     * Handle the change email request.
     *
     * @param  \Bitaac\Account\Http\Requests\Change\EmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post(EmailRequest $request)
    {
        $user = $this->auth->user();
        $time = config('bitaac.account.change-email-time');

        if (! $this->auth->validate(['name' => $user->name, 'password' => $request->get('password')])) {
            return back()->withErrors([
                'error' => 'Password did not match.',
            ])->withInput();
        }

        if ($time == 0) {
            $user->email = $request->get('email');
            $user->save();

            return back()->withSuccess('Your email has been updated.');
        }

        $updates = Carbon::now()->addSeconds($time)->toDateTimeString();

        $user->bitaac->email_change_time = strtotime($updates);
        $user->bitaac->email_change_new = $request->get('email');
        $user->bitaac->save();

        return back()->with([
            'success' => 'You have requested to change your email address to '.$request->get('email').'. The actual change will take place after '.$updates.', during which you can cancel the request at any time.',
        ]);
    }
}
