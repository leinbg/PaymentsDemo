<?php 

use App\Plan;
use Stripe\Token;

/**
 * Stripe Information Getter
 */
trait StripeInfoGenerator
{
    public function getTestPlan()
    {
        return new Plan(['name' => 'monthly']);
    }

    protected function getTestStripeToken()
    {
    	return Token::create([
        	'card' => [
        		'number' => '4242424242424242',
        		'exp_month' => 3,
        		'exp_year' => \Carbon\Carbon::now()->addYear(3)->year,
        		'cvc' => 123,
        	]
		]);
    }
}