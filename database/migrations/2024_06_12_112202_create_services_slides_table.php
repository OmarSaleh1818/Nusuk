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
        Schema::create('services_slides', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('slide_id');
            $table->boolean('outside_kingdom')->nullable();
            $table->boolean('inside_kingdom')->nullable();
            $table->boolean('female')->nullable();
            $table->boolean('special_needs')->nullable();
            $table->boolean('people_dead')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_slides');
    }
};
