<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'seller_id' => User::factory(), // Menghubungkan dengan User
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'weight' => $this->faker->randomFloat(2, 1, 10),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'stock' => $this->faker->numberBetween(1, 100),
            'rating' => $this->faker->randomFloat(2, 0, 5),
            'status' => 'active',
            'payment_availability' => true,
            'promotion_set' => null,
            'promotion_get' => null,
            'primary_image' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}