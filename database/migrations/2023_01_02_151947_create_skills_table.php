<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// THIS TABLE REQUIRES A FIELD_ID


return new class extends Migration
{
    /**
     * Run skill migrations
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->unsignedSmallInteger('field_id')->nullable(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse skill migrations
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
