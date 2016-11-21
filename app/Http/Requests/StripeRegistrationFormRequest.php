<?php

namespace App\Http\Requests;

use App\Plan;
use Illuminate\Foundation\Http\FormRequest;
use Stripe\Customer;

/**
 * Class StripeRegistrationFormRequest
 *
 * @package App\Http\Requests
 */
class StripeRegistrationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripeEmail' => 'required|email',
            'stripeToken' => 'required',
            'plan' => 'required'
        ];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function save()
    {
        $plan = Plan::findOrFail($this->plan);

        $customer = Customer::create(array(
            'email' => $this->stripeEmail,
            'source'  => $this->stripeToken,
            'plan' => $plan->name,
        ));

        $this->user()->activateStripe($customer->id);
    }
}
