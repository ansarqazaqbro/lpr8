<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\MenuSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_section_id' => MenuSection::factory(),
            'name' => mb_convert_case(fake()->unique()->words(rand(1, 3), true), MB_CASE_TITLE),
            'description' => fake()->optional()->realText(100),
            'weight_g' => fake()->numberBetween(150, 600),
            'price' => fake()->randomFloat(2, 1500, 8000),
            'calories' => fake()->numberBetween(200, 900),
            'is_vegan' => fake()->boolean(25),
        ];
    }
}
