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

        $TITLES = [
            'Industrial Plant Construction',
            'Commercial Building Renovation',
            'Infrastructure Development Project',
            'Residential Complex Development',
            'Renewable Energy Facility Setup',
            'Transportation Hub Expansion',
        ];

        $DESCRIPTION = [
            'A comprehensive project involving the construction of a state-of-the-art industrial plant, incorporating advanced technologies and sustainable practices to optimize production efficiency and minimize environmental impact.',
            'This renovation project focuses on modernizing a commercial building to enhance its aesthetic appeal, functionality, and energy efficiency while preserving its historical significance.',
            'An ambitious infrastructure development project aimed at improving transportation networks, utilities, and public amenities to support urban growth and enhance the quality of life for residents.',
            'The development of a residential complex that offers modern living spaces, recreational facilities, and green areas, designed to foster a sense of community and promote sustainable living.',
            'A project dedicated to setting up a renewable energy facility that harnesses solar and wind power to provide clean, sustainable energy solutions for local communities and businesses.',
            'An expansion project for a major transportation hub, aimed at increasing capacity, improving passenger experience, and integrating advanced technologies for efficient operations.',
        ];

        $imageCount = random_int($MIN, $MAX);
        $shuffled = $IMAGES;
        shuffle($shuffled);
        $imagePaths = array_slice($shuffled, 0, $imageCount); // populate random images uniquely from defined IMAGES.

        $status = ['pending', 'on_going', 'completed'];
        
        return [
            "images" => $imagePaths,
            "job_order" => random_int(1000, 9999) . '-' . random_int(1000, 9999),
            "title" => $TITLES[array_rand($TITLES)],
            "description" => $DESCRIPTION[array_rand($DESCRIPTION)],
            "status" => $status[random_int(0, 2)],
            "is_visible" => random_int(0, 1),
            "is_featured" => 0,
        ];
    }
}
