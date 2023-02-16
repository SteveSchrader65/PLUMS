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

