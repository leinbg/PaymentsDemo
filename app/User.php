<?php

namespace App;

use App\Payment;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

      /**
     * @param $customerId
     *
     * @return bool
     */
    public function activateStripe($customerId, $subscriptionId)
    {
        return $this->update([
            'stripe_id' => $customerId,
            'stripe_active' => true,
            'stripe_subscription_id' => $subscriptionId,
            'stripe_subscription_end_at' => null,
        ]);
    }

    public function reactivateStripe()
    {
        return $this->update([
            'stripe_active' => true,
            'stripe_subscription_end_at' => null, 
        ]);
    }

    public function deactivateStripe($endDate = null)
    {
        $endDate = $endDate ?: Carbon::now();
        return $this->update([
            'stripe_active' => false,
            'stripe_subscription_end_at' => $endDate,
        ]);
    }

    /**
     * get subscription class for the user
     */
    public function subscription()
    {
        return new Subscription($this);
    }

    public function isSubscript()
    {
        return !! $this->stripe_active && $this->stripe_subscription_end_at == NULL;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
