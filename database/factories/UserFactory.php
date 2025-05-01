<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Definisi default model untuk factory.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Enkripsi password
            'phone_number' => $this->faker->numerify('08##########'), // Nomor HP acak
            'type' => $this->faker->randomElement(array_keys(User::TYPE)), // Pilih tipe user acak
            'profile_picture' => $this->faker->imageUrl(200, 200, 'people', true, 'profile'), // Gambar random
            'ewallet_balance' => $this->faker->randomFloat(2, 0, 1000000), // Saldo e-wallet acak
            'activation' => $this->faker->boolean(80), // 80% kemungkinan aktif
            'full_address' => $this->faker->address,
            'raja_ongkir_city_id' => $this->faker->numberBetween(1, 500), // ID Kota acak
            'raja_ongkir_province_id' => $this->faker->numberBetween(1, 34), // ID Provinsi acak
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
