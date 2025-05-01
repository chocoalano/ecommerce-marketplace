<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(), // Menghubungkan dengan Order
            'product_id' => Product::factory(), // Menghubungkan dengan Product
            'qty' => $this->faker->numberBetween(1, 5), // Jumlah item
            'item_price' => $this->faker->randomFloat(2, 10, 100), // Harga per item
            'total_price' => function (array $attributes) {
                return $attributes['qty'] * $attributes['item_price']; // Total harga
            },
            'total_weight' => $this->faker->randomFloat(2, 1, 10), // Total berat
            'province_store' => $this->faker->city,
            'city_store' => $this->faker->city,
            'province_id_ro_shipping' => $this->faker->numberBetween(1, 34), // Contoh ID provinsi
            'city_id_ro_shipping' => $this->faker->numberBetween(1, 100), // Contoh ID kota
            'courier_ro_shipping' => $this->faker->word,
            'packet_ro_shipping' => $this->faker->word,
            'cost_ro_shipping' => $this->faker->randomFloat(2, 5, 50), // Biaya pengiriman
            'list_ro_shipping_option' => json_encode([$this->faker->word, $this->faker->word]), // Opsi pengiriman
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}