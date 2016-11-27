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
	use DatabaseTransactions;

    public function testUserSubscription()
    {
        // Given: I have an active user
		$user = factory(User::class)->create([
			'stripe_active' => false,
		]);

        // When: I create a subscription for the user
        $plan = new Plan(['name' => 'monthly']);
        $token = Token::create([
        	'card' => [
        		'number' => '4242424242424242',
        		'exp_month' => 3,
        		'exp_year' => Carbon\Carbon::now()->addYear(3)->year,
        		'cvc' => 123,
        	]
		]);
		(new Subscription($user))->createUser($token, $plan);

        // Then: they should have a subscription with stripe and be active in db
        $user = $user->fresh();
        $this->assertTrue(!! $user->stripe_active);
        $this->assertNotNull($user->stripe_id);
    }
}
