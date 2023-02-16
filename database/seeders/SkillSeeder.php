<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class SkillSeeder extends Seeder
{
    /**
     * Seed the study-field skills database table
     *
     * @return void
     */
    public function run(): void
    {
        $seedSkills = [
            [
                'name' => "Programming",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 11,
            ],
            [
                'name' => "Web Design",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 11,
            ],
            [
                'name' => "Networking",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 11,
            ],
            [
                'name' => "Counselling",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 7,
            ],
            [
                'name' => "Auslan",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 7,
            ],
            [
                'name' => "Fashion Design",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 6,
            ],
            [
                'name' => "Hotel Management",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 10,
            ],
            [
                'name' => "Accountancy",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 5,
            ],
            [
                'name' => "Engineering",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 8,
            ],
            [
                'name' => "Finance Management",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 5,
            ],
            [
                'name' => "Business Management",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 5,
            ],
            [
                'name' => "Japanese Language Skills",
                'description' => "ENTER DESCRIPTION HERE",
                'field_id' => 12,
            ],
        ];

        $countItems = count($seedSkills);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems Skill specializations ...");

        foreach ($seedSkills as $item) {
            $skill['name'] = $item['name'];
            $skill['description'] = $item['description'];
            $skill['field_id'] = $item['field_id'];
            Skill::create($skill);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}

