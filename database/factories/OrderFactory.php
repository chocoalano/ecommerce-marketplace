<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'buyer_id' => User::factory(), // Menghubungkan dengan User
            'payment_id' => null, // Akan diisi di seeder
            'total_price' => $this->faker->randomFloat(2, 20, 500),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}