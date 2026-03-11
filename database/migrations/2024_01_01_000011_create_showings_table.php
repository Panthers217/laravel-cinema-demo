<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->dateTime('show_time');
            $table->string('hall')->default('Hall 1');
            $table->integer('available_seats');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showings');
    }
};
