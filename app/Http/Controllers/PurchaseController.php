<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

/**
 * Class PurchaseController
 *
 * @package App\Http\Controllers
 */
class PurchaseController extends Controller
{

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $product = Product::findOrFail($request->product);

        try {
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken,
            ));

            Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $product->price,
                'currency' => 'eur'
            ));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
