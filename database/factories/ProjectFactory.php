<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
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
        $start = $this->faker->dateTimeBetween('-1 year', '+1 month');
        $end = $this->faker->dateTimeBetween($start, '+1 year');

        return [
            'name' => $this->faker->unique()->sentence(3),
            'status' => 'Active',
            'value' => $this->faker->randomFloat(2, 1000, 10000),
            'start_date' => $start,
            'end_date' => $end,
            'creator_id' => User::factory(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(function () {
            return [
                'status' => 'Inactive',
            ];
        });
    }
}
