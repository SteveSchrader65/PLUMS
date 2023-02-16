<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class QuizSeeder extends Seeder
{
    /**
     * Seed the PLUMS quizzes database table
     *
     * @return void
     */
    public function run(): void
    {
        $seedQuizzes = [
            [
                'title' => 'Quiz One',
                'description' => 'Quiz 1 will test your knowledge of programming at an intermediate level.',
                'question_set'=> '[1, 4, 7, 9]',
                'level_id' => 1,
                'field_id' => 2,
                'skill_id' => 11,
                'is_available' => True,
            ],
            [
                'title' => 'Quiz Two',
                'description' => 'BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES',
                'question_set'=> '[1, 3, 5, 6]',
                'level_id' => 1,
                'field_id' => 7,
                'skill_id' => 5,
                'is_available' => True,
            ],
            [
                'title' => 'Quiz Three',
                'description' => 'BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES',
                'question_set'=> '[2, 3, 7, 8]',
                'level_id' => 5,
                'field_id' => 4,
                'skill_id' => 11,
                'is_available' => True,
            ],
            [
                'title' => 'Quiz Four',
                'description' => 'BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES',
                'question_set'=> '[3, 4, 6, 10]',
                'level_id' => 4,
                'field_id' => 5,
                'skill_id' => 11,
                'is_available' => True,
            ],
        ];

        $countItems = count($seedQuizzes);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems PLUMS quizzes ...");

        foreach ($seedQuizzes as $item) {
            $quiz['title'] = $item['title'];
            $quiz['description'] = $item['description'];
            $quiz['question_set'] = $item['question_set'];
            $quiz['level_id'] = $item['level_id'];
            $quiz['field_id'] = $item['field_id'];
            $quiz['skill_id'] = $item['skill_id'];
            $quiz['is_available'] = $item['is_available'];
            $quiz['times_attempted'] = 0;
            $quiz['prepared_by'] = 1;
            $quiz['fastest_time'] = 0;
            $quiz['average_time'] = 0;

            $questions = json_decode($quiz['question_set']);
            $set_copy = $questions;

            // Check if the question can be added to a quiz
            foreach ($questions as $key => $question) {
                if ((int)$question) {
                    $this_question = Question::query()
                        ->where('id', (int)$question)
                        ->find((int)$question);

                    if ($this_question['is_available']) {
                        $this_question['times_used'] += 1;
                        $this_question->save();
                    } else {
                        // Remove the unavailable question from the set
                        array_splice($set_copy, $key, 1);
                    }
                }
            }

            $quiz['question_set'] = json_encode($set_copy);
            Quiz::create($quiz);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}

