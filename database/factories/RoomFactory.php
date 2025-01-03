<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id'=> Hotel::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price_per_night' => $this->faker->randomFloat(2, 10),
            'beds' => $this->faker->numberBetween(2, 10),
            'type' => $this->faker->randomElement(['single', 'double']),
        ];
    }
}
