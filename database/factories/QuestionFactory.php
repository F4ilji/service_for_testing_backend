<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\TypeQuest;
use App\Models\DifficultlyQuest;
use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quest' => fake()->paragraph(),
            'test_id' => Test::get()->random()->id,
        ];
    }
}
