<?php

use App\Plan;
use App\User;
use Stripe\Token;
use App\Subscription;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscriptionTest extends TestCase
{
	use DatabaseTransactions, StripeInfoGenerator;

    public function testUserSubscription()
    {
        // Given: I have an active user
		$user = factory(User::class)->create([
			'stripe_active' => false,
		]);

        // When: I create a subscription for the user
		(new Subscription($user))->createUser($this->getTestStripeToken(), $this->getTestPlan());

        // Then: they should have a subscription with stripe and be active in db
        $this->assertTrue($user->fresh()->isSubscript());
        try {
        	(new Subscription($user->fresh()))->retrieve();
        } catch (\Exception $e) {
        	$this->fail('can not fetch a stripe subscription');
        }
    }
}
