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
        Schema::create('volunteer_information', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('nationality_id');
            $table->integer('gender_id');
            $table->integer('age_id');
            $table->integer('region_id');
            $table->integer('contract_id');
            $table->integer('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_information');
    }
};
