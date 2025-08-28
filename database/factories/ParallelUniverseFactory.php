<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParallelUniverse>
 */
class ParallelUniverseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true) . ' Universe',
            'divergence_point' => fake()->sentence(),
            'divergence_year' => fake()->numberBetween(1000, 2024),
            'description' => fake()->paragraph(),
            'cover_image_path' => null,
        ];
    }
}