<?php
namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class QuestionSeeder extends Seeder
{
    /**
     * Seed available questions table (can be added to any quiz)
     *
     * @return void
     */
    public function run(): void
    {
        $seedQuestions = [
            [
                'question_text' => 'Which of the following statements are true about OOP?',
                'answer_set' => '[1, 4, 9, 14, 16]',
                'points_value' => 5,
                'is_available' => True,
                'written_by' => 2,
            ],
            [
                'question_text' => 'Which of the following statements apply to SQL?',
                'answer_set' => '[7, 12, 15, 20]',
                'points_value' => 5,
                'is_available' => True,
                'written_by' => 3,
            ],
            [
                'question_text' => 'Which of the following statements are true of the term "Client Business Domain"?',
                'answer_set' => '[3, 5, 10, 13, 17, 22]',
                'points_value' => 2.5,
                'is_available' => True,
                'written_by' => 1,
            ],
            [
                'question_text' => 'Read the following definition carefully: Abstraction is the provision of essential information to the outside world, whilst hiding the details of how that data is stored and manipulated.',
                'answer_set' => '[27, 30]',
                'points_value' => 1,
                'is_available' => False,
                'written_by' => 2,
            ],
            [
                'question_text' => 'Read the following definition carefully: Modularization is the capability to create a new class based upon the blueprint, or template, provided by an existing class.',
                'answer_set' => '[28, 29]',
                'points_value' => 0.5,
                'is_available' => True,
                'written_by' => 2,
            ],
            [
                'question_text' => 'What is the commonly known name for the NOSQL language developed by Facebook?',
                'answer_set' => '[2, 6, 18]',
                'points_value' => 1,
                'is_available' => True,
                'written_by' => 2,
            ],
            [
                'question_text' => 'There are many terms relating to security with regards to the Web. Which of the following statements are most appropriate to define Authentication?',
                'answer_set' => '[11, 19, 25]',
                'points_value' => 0.5,
                'is_available' => True,
                'written_by' => 1,
            ],
            [
                'question_text' => 'When the data contained in a database is mainly used for read-based processes, which of the following may be used to improve performance?',
                'answer_set' => '[23, 24]',
                'points_value' => 5,
                'is_available' => False,
                'written_by' => 2,
            ],
            [
                'question_text' => 'Read the following definition carefully: Inheritance is the capability to create a new class based upon the blueprint, or template, provided by an existing class.',
                'answer_set' => '[27, 30]',
                'points_value' => 0.5,
                'is_available' => True,
                'written_by' => 1,
            ],
            [
                'question_text' => 'For what does the acronym HTTPS stand?',
                'answer_set' => '[8, 21, 26]',
                'points_value' => 3.5,
                'is_available' => True,
                'written_by' => 3,
            ],
        ];

        $countItems = count($seedQuestions);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems quiz Questions ...");

        foreach ($seedQuestions as $item) {
            $question['question_text'] = $item['question_text'];
            $question['answer_set'] = $item['answer_set'];
            $question['points_value'] = $item['points_value'];
            $question['is_available'] = $item['is_available'];
            $question['written_by'] = $item['written_by'];
            $question['times_used'] = 0;
            $question['times_answered_correctly'] = 0;
            $question['times_answered_incorrectly'] = 0;

            Question::create($question);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}
