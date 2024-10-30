<?php

namespace Database\Factories;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'comments' => $this->faker->text(),
            'planned_at' => Carbon::now()->addDay(10)->format('Y-m-d'),
            'user_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
