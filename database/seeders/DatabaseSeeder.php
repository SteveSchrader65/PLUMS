<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database tables for the PLUMS application
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
//            RolesSeeder::class,
//            PermissionsSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            FieldSeeder::class,
            SkillSeeder::class,
            LevelSeeder::class,
            AnswerSeeder::class,
            QuestionSeeder::class,
            QuizSeeder::class,
        ]);
    }
}
