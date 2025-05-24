<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('now_watchings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('movie_or_show_id')->unsigned();
            $table->bigInteger('season')->unsigned()->nullable();  // since postgresql does not have unsigned types, this will help make it croos pltform
            $table->bigInteger('episode')->unsigned()->nullable();
            $table->bigInteger('left_time')->unsigned()->nullable();
            $table->bigInteger('runtime')->unsigned()->nullable();
            $table->string('media_type')->only(['movie', 'tv']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('now_watchings');
    }
};
