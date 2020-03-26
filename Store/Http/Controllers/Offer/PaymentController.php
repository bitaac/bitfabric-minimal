<?php

namespace Bitaac\Store\Http\Controllers\Offer;

use Illuminate\Http\Request;
use Bitaac\Store\Models\Payment;
use \Facades\Paysterify\Paysterify;
use Bitaac\Laravel\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Show the paypal offers to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($gateway)
    {
        $gateway = config("bitaac.store.gateways.$gateway");

        if (! $gateway or ! $gateway['enabled']) {
            return redirect('/store/offers');
        }

        return view('store.offers.form')->with([
            'gateway' => (object) $gateway,
        ]);
    }

    /**
     * Create & Process the payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, $provider)
    {
        // Verify that the amount exists as a offer.
        if (! isset(config("bitaac.store.gateways.$provider.offers")[$request->get('amount')])) {
            return back()->withErrors('Something went wrong, please try again.');
        }

        $config = (object) config("bitaac.store.gateways.$provider");

        $params = [
            'amount'        => $request->get('amount'),
            'currency'      => $config->currency,

            'sandbox'       => $config->sandbox,
            'description'   => $config->description,

            'client'        => $config->client,
            'secret'        => $config->secret,
            'url_return'    => route('gateway.return', ['gateway' => $provider]),
            'url_cancel'    => route('gateway.cancel', ['gateway' => $provider]),
        ];

        $paysterify = Paysterify::gateway($config->paysterify)->configure($params)->purchase();

        $request->session()->put('params', $params);

        return $paysterify->redirect();
    }

    /**
     * Complete the payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function return(Request $request, $provider)
    {
        $params = $request->session()->get('params');
        $config = (object) config("bitaac.store.gateways.$provider");

        $paysterify = Paysterify::gateway($config->paysterify)->configure($params)->completePurchase([
            'paymentId' => $request->get('paymentId'),
            'payerId' => $request->get('PayerID'),
        ]);

        // Make sure the payment was successful.
        if (! $paysterify->isCompleted()) {
            return back()->withErrors('Something went wrong.');
        }

        $data = $paysterify->getResponse();

        $payment = Payment::where(function ($query) use ($data, $provider) {
            $query->where('payment_id', $data->id);
            $query->where('method', $provider);
        });

        // Make sure the payment already has been processed
        if ($payment->exists()) {
            return back()->withErrors('Payment has already been processed.');
        }

        $payment = new Payment;
        $payment->payment_id = $data->id;
        $payment->method = $provider;
        $payment->currency = $paysterify->getCurrency();
        $payment->amount = $paysterify->getAmount();
        $payment->account_id = auth()->user()->id;
        $payment->points = config("bitaac.store.gateways.$provider.offers")[$paysterify->getAmount()];
        $payment->save();

        $user = auth()->user()->bitaac;
        $user->points = $user->points + $payment->points;
        $user->total_points = $user->total_points + $payment->points;
        $user->save();

        return redirect('/store')->withSuccess("Thanks for your purchase, {$payment->points} points has been added to your account.");
    }

    /**
     * Cancel the payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        return redirect('/store/offers')->withError('The payment transaction has been cancelled.');
    }
}
