<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //  'nama', 'harga', 'deskripsi', 'kondisi', 'lokasi', 'kategori', 'photo'
            'nama' => $this->faker->firstNameMale,
            'harga' => $this->faker->randomDigit,
            'deskripsi' => $this->faker->text(200),
            'kondisi' => $this->faker->text(100),
            'lokasi' => $this->faker->city,
            'kategori' => $this->faker->country,
            'photo' => $this->faker->name
        ];
    }
}
