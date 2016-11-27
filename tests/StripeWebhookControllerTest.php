<?php

use App\User;
use App\Http\Controllers\StripeWebhookController;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StripeWebhookControllerTest extends TestCase
{
	use DatabaseTransactions;

    /**
     * unit test of function generateEventMethod
     * 
     * @return void
     */
    public function testConvertStripeEventToMethodName()
    {
    	$event = 'customer.subscription.deleted';
    	$method = 'onCustomerSubscriptionDeleted';

    	$this->assertEquals($method, (new StripeWebhookController)->generateEventMethod($event));
    }
/**
 * functional test of StripeWebhook handle customer subscription deleted event
 * @return [type] [description]
 */
    public function testWhenHitCustomerSubscriptionDeletedWebHookDeactivateUser()
    {
    	// Given: I have a user
    	$fakeStripeId = 'fake_stripe_id';
    	$user = factory(User::class)->create([
    		'stripe_id' => $fakeStripeId,
    		'stripe_active' => 1,
    		'stripe_subscription_end_at' => NULL,
		]);

    	// When: customer subscription deleted webhook triggered
    	$this->post('stripe/webhook', [
    		'type' => 'customer.subscription.deleted',
    		'data' => [
    			'object' => [
    				'customer' => $fakeStripeId,
    			],
    		],
		]);

    	// Then: user should be deactivated
		$this->assertEquals($user->fresh()->stripe_active, 0);
		$this->assertNotNull($user->fresh()->stripe_subscription_end_at);
    }
}
