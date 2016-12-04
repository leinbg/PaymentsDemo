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
		$user = $this->createStripeSubscriptionUser(['stripe_active' => false]);

        // Then: they should have a subscription with stripe and be active in db
        $user = $user->fresh();
        $this->assertTrue($user->isSubscript());
        try {
        	$user->subscription()->retrieveStripeSubscription();
        } catch (\Exception $e) {
        	$this->fail('can not fetch a stripe subscription');
        }
    }

    public function testUserCancelSubscription()
    {
        $user = $this->createStripeSubscriptionUser();
        $user->subscription()->cancel();
        $stripeSubscription = $user->subscription()->retrieveStripeSubscription();

        $this->assertNotNull($stripeSubscription->canceled_at);
        $this->assertFalse($user->isSubscript());
        $this->assertNotNull($user->stripe_subscription_end_at);
    }

    protected function createStripeSubscriptionUser($overrides = [])
    {
        $user = factory(User::class)->create($overrides);
        // When: I create a subscription for the user
        $user->subscription()->createUser($this->getTestStripeToken(), $this->getTestPlan());

        return $user;
    }
}
