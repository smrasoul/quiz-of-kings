<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
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

        Category::factory(5)->create()->each(function ($category) {
            $category->questions()->saveMany(Question::factory(10)->make())
                ->each(function ($question) {
                    // Generate 4 options
                    $options = QuestionOption::factory(4)->make();

                    // Randomly select one option and mark it as correct
                    $options->random()->is_correct = true;

                    // Save options
                    $question->questionOptions()->saveMany($options);
                });
        });
    }
}
