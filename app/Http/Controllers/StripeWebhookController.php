<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
	public function handle()
	{
		$payload = request()->all();

		if ($payload['type'] == 'customer.subscription.deleted') {
			$user = User::where('stripe_id', $payload['data']['object']['customer'])->firstOrFail();
			$user->deactivateStripe();

			return response('webhook successful!');
		}
	}
}
