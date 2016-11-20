<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Stripe\{Customer, Stripe};

/**
 * Class SubscriptionController
 *
 * @package App\Http\Controllers
 */
class SubscriptionController extends Controller
{

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $plan = Plan::findOrFail($request->plan);

        try {
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken,
                'plan' => $plan->name,
            ));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $request->user()->activateStripe($customer->id);

        return [
            'message' => 'success'
        ];
    }
}
