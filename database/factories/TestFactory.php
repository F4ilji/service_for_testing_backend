<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\DifficultlyTest;
use App\Models\DifficultlyQuest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'difficulty_id' => DifficultlyTest::get()->random()->id,
            'category_id' => Category::get()->random()->id,
        ];
    }
}
