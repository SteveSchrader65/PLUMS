<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class LevelSeeder extends Seeder
{
    /**
     * Seed the AQF levels database table
     *
     * @return void
     */
    public function run(): void
    {
        $seedLevels = [
            [
                'AQF_level' => '1',
                'title' => 'Certificate I',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy in highly structured and stable contexts and within narrow parameters.',
            ],
            [
                'AQF_level' => '2',
                'title' => 'Certificate II',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy and limited judgement in structured and stable contexts and within narrow parameters.',
            ],
            [
                'AQF_level' => '3',
                'title' => 'Certificate III',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy and judgement and to take limited responsibility in known and stable contexts within established parameters.',
            ],
            [
                'AQF_level' => '4',
                'title' => 'Certificate IV',
                'description' => 'Graduates at this level will have a broad range of cognitive, technical and communication skills to select and apply a range of methods, tools, materials and information.',
            ],
            [
                'AQF_level' => '5',
                'title' => 'Diploma',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy, judgement and defined responsibility in known or changing contexts and within broad but established parameters.',
            ],
            [
                'AQF_level' => '6',
                'title' => 'Advanced Diploma',
                'description' => 'Graduates at this level will have a broad range of cognitive, technical and communication skills to select and apply methods and technologies.',
            ],
            [
                'AQF_level' => '7',
                'title' => 'Degree (Bachelor)',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy, well-developed judgement and responsibility in contexts that require self-directed work and learning.',
            ],
            [
                'AQF_level' => '8',
                'title' => 'Degree (Honours)',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy, well-developed judgement, adaptability and responsibility as a practitioner or learner.',
            ],
            [
                'AQF_level' => '9',
                'title' => 'Degree (Masters)',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy, expert judgement, adaptability and responsibility as a practitioner or learner.',
            ],
            [
                'AQF_level' => '10',
                'title' => 'Doctorate',
                'description' => 'Graduates at this level will apply knowledge and skills to demonstrate autonomy, authoritative judgement, adaptability and responsibility as an expert and leading practitioner or scholar.',
            ],
        ];

        $countItems = count($seedLevels);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems AQF levels ...");

        foreach ($seedLevels as $item) {
            $level['AQF_level'] = $item['AQF_level'];
            $level['title'] = $item['title'];
            $level['description'] = $item['description'];
            Level::create($level);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}
