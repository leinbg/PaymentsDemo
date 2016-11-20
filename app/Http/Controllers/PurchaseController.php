<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class PurchaseController extends Controller
{

    public function store(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $customer = Customer::create(array(
            'email' => $request->stripeEmail,
            'source'  => $request->stripeToken,
        ));

        Charge::create(array(
            'customer' => $customer->id,
            'amount'   => 5000,
            'currency' => 'eur'
        ));

        echo '<h1>Successfully charged $50.00!</h1>';
    }
}
