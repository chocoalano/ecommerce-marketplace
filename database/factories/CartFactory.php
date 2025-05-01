<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'buyer_id' => User::factory(), // Menghubungkan dengan User
            'total_price' => $this->faker->randomFloat(2, 10, 500),
            'product_id' => Product::factory(), // Menghubungkan dengan Product
            'qty' => $this->faker->numberBetween(1, 5),
            'ispay' => $this->faker->boolean(50), // 50% kemungkinan
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}