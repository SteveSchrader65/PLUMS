<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run quiz migrations
     *
     * @return void
     */
    public function up(): void
    {
//        NOTE: CONDITION WHEREBY ALL VALUES MUST BE VALID, OTHERWISE CAN BE null
//              if (isset($item['is_available']) && $item['is_available']) {
//
//        $quiz['title'] = $item['title'];
//        $quiz['description'] = $item['description'];
//        $quiz['question_set'] = $item['question_set'];
//        $quiz['level_id'] = $item['level_id'];
//        $quiz['field_id'] = $item['field_id'];
//        $quiz['skill_id'] = $item['skill_id'];
//        $quiz['is_available'] = $item['is_available'];
//        $quiz['times_attempted'] = 0;
//        $quiz['prepared_by'] = 1;
//        $quiz['fastest_time'] = '000345';
//        $quiz['average_time'] = '000500';
//         OTHERWISE, ITEMS MAY CURRENTLY HOLD null VALUES
//         AS THE is_available FLAG INDICATES THAT A QUIZ IS
//         CURRENTLY 'UNDER CONSTRUCTION'
//        }
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->json('question_set')->nullable(1);
            $table->unsignedSmallInteger('level_id');
            $table->unsignedSmallInteger('field_id');
            $table->unsignedSmallInteger('skill_id');
            $table->boolean('is_available')->default(0);
            $table->unsignedInteger('prepared_by')->nullable(1);
            $table->unsignedInteger('times_attempted')->default(0);
            $table->time('fastest_time')->default(0);
            $table->time('average_time')->default(0);
            $table->json('questions')->nullable(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Drop quiz migrations
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};

