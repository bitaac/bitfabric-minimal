<?php

namespace Bitaac\Admin\Http\Controllers\Payments;

use Bitaac\Store\Models\Payment;
use Bitaac\Laravel\Http\Controllers\Controller;

class PaymentsController extends Controller
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
     * [GET] /admin/payments
     *
     * @param  \Bitaac\Store\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function get(Payment $payment)
    {
        return view('admin::payments.index')->with([
            'payments' => $payment->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
