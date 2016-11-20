<?php

use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Plan::create([
            'name' => 'monthly',
            'description' => 'subscribe monthly',
            'price' => '1000',
        ]);
        \App\Plan::create([
            'name' => 'yearly',
            'description' => 'subscribe yearly',
            'price' => '10000',
        ]);
    }
}
