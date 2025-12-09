<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Contents\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $MIN = 1;
        $MAX = 6;

        $IMAGES = [
            'images/landscape/johannes-plenio-RwHv7LgeC7s-unsplash.jpg',
            'images/landscape/leonard-cotte-c1Jp-fo53U8-unsplash.jpg',
            'images/landscape/matthew-smith-Rfflri94rs8-unsplash.jpg',
            'images/landscape/qingbao-meng-01_igFr7hd4-unsplash.jpg',
            'images/landscape/quaritsch-photography-lIYBssO6ahY-unsplash.jpg',
            'images/landscape/sergey-shmidt-koy6FlCCy5s-unsplash.jpg',
        ];

        $imageCount = random_int($MIN, $MAX);
        $shuffled = $IMAGES;
        shuffle($shuffled);
        $imagePaths = array_slice($shuffled, 0, $imageCount); // populate random images uniquely from defined IMAGES.

        $status = ['pending', 'on_going', 'completed'];

        return [
            "images" => $imagePaths,
            "job_order" => random_int(1000, 9999) . '-' . random_int(1000, 9999),
            "title" => fake()->sentence(4),
            "description" => fake()->sentence(20),
            "status" => $status[random_int(0, 2)],
            "is_visible" => random_int(0, 1),
            "is_featured" => 0,
        ];
    }
}
