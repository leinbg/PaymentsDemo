<?php

namespace App;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'stripe_id', 'stripe_active', 'stripe_subscription_end_at'
    ];

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
    public function activateStripe($customerId)
    {
        return $this->update([
            'stripe_id' => $customerId,
            'stripe_active' => true,
        ]);
    }

    /**
     * get subscription class for the user
     */
    public function subscription()
    {
        return new Subscription($this);
    }
}
