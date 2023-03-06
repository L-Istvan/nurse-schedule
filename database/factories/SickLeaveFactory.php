<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sick_leave>
 */
class SickLeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $randtime = $faker->dateTimeBetween("2023-03-01", "2023-03-25");
        return [
            'user_id' =>4,
            'date' => $randtime,
        ];
    }
}
