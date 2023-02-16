<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AnswerSeeder extends Seeder
{
    /**
     * Seed Answer database table
     *
     * @return void
     */
    public function run(): void
    {
        $seedAnswers = [
            [
                'id' => 1,
                'answer_text' => 'OOP stands for Object-Oriented Programming',
                'is_correct' => true,
            ],
            [
                'id' => 2,
                'answer_text' => 'MetaverseQL',
                'is_correct' => false,
            ],
            [
                'id' => 3,
                'answer_text' => 'The domain is the core business of the client',
                'is_correct' => true,
            ],
            [
                'id' => 4,
                'answer_text' => 'OOP places heavy emphasis on modularised coding',
                'is_correct' => true,
            ],
            [
                'id' => 5,
                'answer_text' => 'The domain may be found in the financial statements',
                'is_correct' => false,
            ],
            [
                'id' => 6,
                'answer_text' => 'GraphSQL',
                'is_correct' => true,
            ],
            [
                'id' => 7,
                'answer_text' => 'There are two parts, one of which is a data manipulation language',
                'is_correct' => true,
            ],
            [
                'id' => 8,
                'answer_text' => 'Heavy Traffic Transport Packaging System',
                'is_correct' => false,
            ],
            [
                'id' => 9,
                'answer_text' => 'OOP uses classes, methods and properties',
                'is_correct' => true,
            ],
            [
                'id' => 10,
                'answer_text' => 'The domain may be found using company organisational charts',
                'is_correct' => true,
            ],
            [
                'id' => 11,
                'answer_text' => 'Authentication is the process of \'logging into\' a web application',
                'is_correct' => true,
            ],
            [
                'id' => 12,
                'answer_text' => 'It is formally known as Structured Query Language',
                'is_correct' => true,
            ],
            [
                'id' => 13,
                'answer_text' => 'The domain is determined by the Board of Directors',
                'is_correct' => false,
            ],
            [
                'id' => 14,
                'answer_text' => 'OOP places heavy emphasis on functional coding',
                'is_correct' => false,
            ],
            [
                'id' => 15,
                'answer_text' => 'It is formally known as Structural Question Language',
                'is_correct' => false,
            ],
            [
                'id' => 16,
                'answer_text' => 'OOP stands for Optional-Object Progression',
                'is_correct' => false,
            ],
            [
                'id' => 17,
                'answer_text' => 'The domain can be found on the Company Portal',
                'is_correct' => false,
            ],
            [
                'id' => 18,
                'answer_text' => 'Time-lord',
                'is_correct' => false,
            ],
            [
                'id' => 19,
                'answer_text' => 'Authentication helps the programmer to identify the real elements of an application',
                'is_correct' => false,
            ],
            [
                'id' => 20,
                'answer_text' => 'There are two parts, one of which is a data definition language',
                'is_correct' => true,
            ],
            [
                'id' => 21,
                'answer_text' => 'High Throughput Transport Processing System',
                'is_correct' => false,
            ],
            [
                'id' => 22,
                'answer_text' => 'The domain may be found in the company mission statement',
                'is_correct' => true,
            ],
            [
                'id' => 23,
                'answer_text' => 'Sharding',
                'is_correct' => true,
            ],
            [
                'id' => 24,
                'answer_text' => 'Pipe-lining',
                'is_correct' => false,
            ],
            [
                'id' => 25,
                'answer_text' => 'Authentication often uses recycled passwords to provide a more secure system',
                'is_correct' => false,
            ],
            [
                'id' => 26,
                'answer_text' => 'Hyper Text Transfer Protocol Secured',
                'is_correct' => true,
            ],
            [
                'id' => 27,
                'answer_text' => 'True',
                'is_correct' => true,
            ],
            [
                'id' => 28,
                'answer_text' => 'True',
                'is_correct' => false,
            ],
            [
                'id' => 29,
                'answer_text' => 'False',
                'is_correct' => true,
            ],
            [
                'id' => 30,
                'answer_text' => 'False',
                'is_correct' => false,
            ],
        ];

        $countItems = count($seedAnswers);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems potential quiz Answers ...");

        foreach ($seedAnswers as $item) {
            $answer['id'] = $item['id'];
            $answer['answer_text'] = $item['answer_text'];
            $answer['is_correct'] = $item['is_correct'];
            Answer::create($answer);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}
