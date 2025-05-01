<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Support\RajaOngkir;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    protected $model = Seller::class;

    public function definition()
    {
        $rajaOngkir = new RajaOngkir();
        // Ambil semua provinsi dari RajaOngkir
        $daftarProvinsi = $rajaOngkir->getProvinces();

        // Pilih provinsi secara acak
        $provinsi = $this->faker->randomElement($daftarProvinsi);
        $provinceName = $provinsi['province'];

        // Ambil kota dari provinsi yang dipilih
        $daftarKota = $rajaOngkir->getCities();

        // Pilih kota secara acak
        $kota = $this->faker->randomElement($daftarKota);
        $cityName = $kota['city_name'];

        return [
            'user_id' => User::factory(), // Menghubungkan dengan User
            'store_name' => $this->faker->company, // Nama toko
            'description' => $this->faker->text(200), // Deskripsi toko
            'logo' => $this->faker->imageUrl(640, 480, 'business'), // URL logo
            'store_address' => $this->faker->address, // Alamat toko
            'rating' => $this->faker->randomFloat(1, 1, 5), // Rating antara 1 dan 5
            'store_status' => $this->faker->randomElement(['active', 'suspended']), // Status toko
            'store_type' => $this->faker->randomElement(array_keys(Seller::STORE_TYPE)), // Jenis toko
            'store_time_opened' => $this->faker->time('H:i'), // Waktu buka
            'store_time_closed' => $this->faker->time('H:i'), // Waktu tutup
            'province' => $provinceName, // Provinsi yang dipilih
            'city' => $cityName, // Kota yang dipilih
        ];
    }
}
