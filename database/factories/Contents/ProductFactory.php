<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $IMAGES = [1, 2, 3, 4, 5, 6];

        $imageCount = random_int(1, 6);
        $shuffled = $IMAGES;
        shuffle($shuffled);
        $imagePaths = array_slice($shuffled, 0, $imageCount); // populate random images uniquely from defined IMAGES.


        return [
            "images" => $imagePaths,
            "title" => fake()->sentence(4),
            "is_visible" => random_int(0, 1),
        ];
    }
}
