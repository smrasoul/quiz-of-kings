<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Round;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@yahoo.com'], // Unique identifier
            [
                'id' => 1,
                'name' => 'admin',
                'password' => bcrypt('admin'),
            ],
        );

        User::updateOrCreate(
            ['email' => 'rasoul@yahoo.com'], // Unique identifier
            [
                'id' => 2,
                'name' => 'rasoul',
                'password' => bcrypt('rasoul'),
            ],
        );

        Category::factory(10)->create()->each(function ($category) {
            $category->questions()->saveMany(Question::factory(6)->make())
                ->each(function ($question) {
                    // Generate 4 options
                    $options = QuestionOption::factory(4)->make();

                    // Randomly select one option and mark it as correct
                    $options->random()->is_correct = true;

                    // Save options
                    $question->questionOptions()->saveMany($options);
                });
        });

        Game::updateOrCreate(
            ['id' => 1],
            [
                'player_one_id' => 1,
                'player_two_id' => 2,
                'current_turn' => 1,
            ]
        );

        Round::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'game_id' => 1,
                'round_number' => 1,
                'status' => 0,
                'started_at' => now()
            ]
        );
    }
}
