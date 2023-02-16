<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run AQF level migrations
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('AQF_level');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Drop AQF level migrations
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
