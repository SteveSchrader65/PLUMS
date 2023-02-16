<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
    * Run quiz question migrations
    *
    * @return void
    */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->longText('question_text');
        $table->json('answer_set')->nullable(0);
        $table->unsignedFloat('points_value');
        $table->boolean('is_available')->default(0);
        $table->unsignedInteger('written_by')->nullable(1);
        $table->unsignedInteger('times_used')->default(0)->nullable(0);
        $table->unsignedInteger('times_answered_correctly')->default(0);
        $table->unsignedInteger('times_answered_incorrectly')->default(0);
        $table->json('answers')->nullable(1);
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
    * Drop quiz question migrations
    *
    * @return void
    */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
