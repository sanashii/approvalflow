<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'priority' => $this->faker->randomElement(['Low', 'Normal', 'High']),
            'status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
