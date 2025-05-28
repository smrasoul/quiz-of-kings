<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\RandomCategories;
use App\Models\Round;
use App\Models\RoundAnswer;
use App\Models\RoundQuestion;
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

        // the admin user
        User::updateOrCreate(
            ['email' => 'admin@yahoo.com'], // Unique identifier
            [
                'id' => 1,
                'name' => 'admin',
                'password' => bcrypt('admin'),
            ],
        );

        //some random other user for player 2
        User::updateOrCreate(
            ['email' => 'rasoul@yahoo.com'], // Unique identifier
            [
                'id' => 2,
                'name' => 'rasoul',
                'password' => bcrypt('rasoul'),
            ],
        );

        //random categories with questions and options
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

        //a new game with a new round
        Game::updateOrCreate(
            ['id' => 1],
            [
                'player_one_id' => 1,
                'player_two_id' => 2,
                'current_turn' => 1,
                'last_activity' => now()->timestamp
            ]
        );
        Round::updateOrCreate(
            ['id' => 1],
            [
                'id' => 1,
                'game_id' => 1,
                'round_number' => 1,
                'status' => 0
            ]
        );


        foreach (range(2, 11) as $id) { // Generates 10 games
            Game::updateOrCreate(
                ['id' => $id], // Ensures uniqueness
                [
                    'player_one_id' => 1,
                    'player_two_id' => 2,
                    'current_turn' => 2,
                    'winner_id' => rand(1, 2),
                    'status' => 1,
                    'last_activity' => rand(1708406196, 1748436196)
                ]
            );

            foreach (range(1, 4) as $roundNumber) { // 4 rounds per game
                $roundId = ($id - 1) * 4 + $roundNumber;

                Round::updateOrCreate(
                    ['id' => $roundId],
                    [
                        'game_id' => $id,
                        'category_id' => rand(1, 10),
                        'round_number' => $roundNumber,
                        'status' => 1
                    ]
                );

                foreach (range(1,3) as $order){
                    RoundQuestion::factory()->create([
                        'round_id' => $roundId,
                        'question_id' => 1,
                        'order' => $order,
                    ]);
                    foreach (range(1,2) as $userId){
                        RoundAnswer::factory()->create([
                            'round_id' => $roundId,
                            'question_id' => 1,
                            'user_id' => $userId,
                            'selected_option_id' => rand(1,4),
                            'is_correct' => rand(0, 1),
                        ]);
                    }
                }
            }
        }






    }
}
