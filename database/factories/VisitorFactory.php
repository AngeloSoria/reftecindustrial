<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonishRoy\VisitorTracking\Models\VisitorTable>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => $this->faker->ipv4(),
            'country' => $this->faker->country(),
            'region' => $this->faker->state(),
            'city' => $this->faker->city(),
            'device' => $this->faker->randomElement(['Desktop', 'Mobile', 'Tablet']),
            'os' => $this->faker->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'browser' => $this->faker->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera']),
            'page_title' => $this->faker->sentence(3),
            'url' => env('APP_URL', 'http://localhost'),
        ];
    }
}
