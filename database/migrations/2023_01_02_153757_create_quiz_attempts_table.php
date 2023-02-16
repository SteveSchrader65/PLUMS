<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// SHOULD THIS BE A PIVOT TABLE ??

return new class extends Migration {
    /**
     * Run migrations for the quiz attempts table
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('user_id');
            $table->json('answers_submitted')->nullable(1);
            $table->unsignedDecimal('score');
            $table->timestamp('attempt_start');
            $table->timestamp('attempt_end');
            $table->timestamps();
        });
    }

    /**
     * Drop quiz attempts table
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
