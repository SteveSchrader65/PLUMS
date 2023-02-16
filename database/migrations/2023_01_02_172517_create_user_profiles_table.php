<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run user-profile migrations
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            // $table->id(); // REPLACED WITH NEXT LINE, AS id IS SET EQUAL TO user_id ON CREATION
            $table->integer('id')->nullable(1);
            $table->string('given_name')->nullable(1);
            $table->string('family_name')->nullable(1);
            $table->string('city')->nullable(1);
            $table->string('country')->nullable(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse user-profile migrations
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
