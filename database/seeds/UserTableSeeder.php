<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'lei',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'stripe_id' => '',
            'stripe_active' => false,
            'stripe_subscription_end_at' => '',
        ]);
    }
}
