<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
	public function handle()
	{
		$payload = request()->all();
		$method = $this->generateEventMethod($payload['type']);
		if (method_exists($this, $method)) {
			$this->$method($payload);
		}

		return response('webhook successful!');
	}

	public function generateEventMethod($event)
	{
		return 'on' . str_replace(' ', '', ucwords(str_replace('.', ' ', $event)));
	}

	public function onCustomerSubscriptionDeleted($payload)
	{
		$this->retrieveUser($payload)->deactivateStripe();
	}

	public function onChargeSucceeded($payload)
	{
		$this->retrieveUser($payload)->payments()->create([
			'amount' => $payload['data']['object']['amount'],
			'charge_id' => $payload['data']['object']['id'],
		]);	
	}

	protected function retrieveUser($payload)
	{
		return User::where(
			'stripe_id', $payload['data']['object']['customer']
		)->firstOrFail();
	}
}
