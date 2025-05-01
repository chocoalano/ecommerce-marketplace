<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Ini tidak akan digunakan jika kita menginsert semua kategori
            'slug' => $this->faker->slug, // Ini tidak akan digunakan jika kita menginsert semua kategori
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function createWithName($name)
    {
        return [
            'name' => $name,
            'slug' => \Str::slug($name), // Menggunakan Str::slug untuk membuat slug dari nama kategori
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}