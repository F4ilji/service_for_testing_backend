<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Test;
use App\Models\User;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\TypeQuest;
use App\Models\TestQuestion;
use App\Models\DifficultlyTest;
use Illuminate\Database\Seeder;
use App\Models\DifficultlyQuest;
use App\Models\TestingSession;
use Database\Factories\TestQuestionFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();


        Category::factory(10)->create();

        DifficultlyTest::factory()->create([
            'title' => 'easy',
        ]);
        DifficultlyTest::factory()->create([
            'title' => 'medium',
        ]);
        DifficultlyTest::factory()->create([
            'title' => 'hard',
        ]);

        Test::factory(10)->create();

        Question::factory(100)->create();
        Answer::factory(400)->create();
    }
}
