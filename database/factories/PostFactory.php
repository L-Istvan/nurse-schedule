<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => 1,
            'person_id' => rand(90,105),
            'date' => fake()->dateTimeBetween('-1 week','+1 week'),
            'position' => rand(1,2),
        ];
    }
}
