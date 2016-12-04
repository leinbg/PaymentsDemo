<?php

namespace App;

use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;

/**
 * Class Subscription
 *
 * @package App
 */
class Subscription
{

    /**
     * @var User
     */
    protected $user;

    /**
     * Subscription constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param      $token
     * @param Plan $plan
     */
    public function createUser($token, Plan $plan)
    {
        $customer = Customer::create([
            'email' => $this->user->email,
            'source'  => $token,
            'plan' => $plan->name,
        ]);

        $subscriptionId = $customer->subscriptions->data[0]->id;

        $this->user->activateStripe($customer->id, $subscriptionId);
    }

    public function cancel($atPeriodEnd = true)
    {
        // cancel subsciption in stripe
        $stripeCustomer = Customer::retrieve($this->user->stripe_id);
        $subscription = $stripeCustomer->cancelSubscription(['at_period_end' => $atPeriodEnd]);

        // cancel subscription in system
        $endDate = \Carbon\Carbon::createFromTimestamp($subscription->current_period_end);
        $this->user->deactivateStripe($endDate);
    }

    public function cancelImmediately()
    {
        $this->cancel(false);
    }

    public function retrieveStripeSubscription()
    {
        return StripeSubscription::retrieve($this->user->stripe_subscription_id);
    }
}
