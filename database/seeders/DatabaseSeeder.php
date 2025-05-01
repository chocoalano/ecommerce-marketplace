<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); // Buat instance Faker

        User::create([
            'name' => 'Administrator',
            'email' => 'administrator@laravel.com',
            'password' => Hash::make('password'), // Enkripsi password
            'phone_number' => '000000000000', // Nomor HP acak
            'type' => 'admin', // Pilih tipe user
            'profile_picture' => $faker->imageUrl(200, 200, 'people', true, 'profile'), // Gambar random
            'ewallet_balance' => 0.00, // Saldo e-wallet default
            'activation' => $faker->boolean(80), // 80% kemungkinan aktif
            'full_address' => $faker->address,
            'raja_ongkir_city_id' => $faker->numberBetween(1, 500), // ID Kota acak
            'raja_ongkir_province_id' => $faker->numberBetween(1, 34), // ID Provinsi acak
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->call(LocationsSeeder::class);
    }
}
