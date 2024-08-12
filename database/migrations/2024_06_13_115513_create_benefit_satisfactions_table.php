<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('benefit_satisfactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('seasonal_question')->nullable();
            $table->integer('ongoing_question')->nullable();
            $table->integer('initiatives_question')->nullable();
            $table->integer('events_question')->nullable();
            $table->integer('seasonal_percentage')->nullable();
            $table->integer('ongoing_percentage')->nullable();
            $table->integer('initiatives_percentage')->nullable();
            $table->integer('events_percentage')->nullable();
            $table->integer('seasonal_size')->nullable();
            $table->integer('ongoing_size')->nullable();
            $table->integer('initiatives_size')->nullable();
            $table->integer('events_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_satisfactions');
    }
};
