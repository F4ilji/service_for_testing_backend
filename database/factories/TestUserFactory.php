<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestUser>
 */
class TestUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'test_id' => $test = Test::get()->random()->id,
            'user_id' => User::get()->random()->id,
            'end_test' => Carbon::now()->addHours($test->test_time)->format('Y-m-d H:i:s'),
        ];
    }
}
