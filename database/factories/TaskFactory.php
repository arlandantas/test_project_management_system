<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(3),
            'status' => $this->faker->randomElement([
                'Pending',
                'Completed',
                'Inactive'
            ]),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
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
