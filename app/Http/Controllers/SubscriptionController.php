<?php

namespace App\Http\Controllers;

use App\Http\Requests\StripeRegistrationFormRequest;

/**
 * Class SubscriptionController
 *
 * @package App\Http\Controllers
 */
class SubscriptionController extends Controller
{

    /**
     * @param StripeRegistrationFormRequest $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function store(StripeRegistrationFormRequest $request)
    {
        try {
            $request->save();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return [
            'message' => 'success'
        ];
    }
}
