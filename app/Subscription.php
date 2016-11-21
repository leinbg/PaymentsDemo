<?php

namespace App;

use Stripe\Customer;

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

        $this->user->activateStripe($customer->id);
    }
}
