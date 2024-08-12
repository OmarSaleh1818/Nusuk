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
        Schema::create('staff_represents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name_notCeo')->nullable();
            $table->string('name_ceo')->nullable();
            $table->string('family_notCeo')->nullable();
            $table->string('family_ceo')->nullable();
            $table->string('position_notCeo')->nullable();
            $table->string('position_ceo')->nullable();
            $table->string('year_notCeo')->nullable();
            $table->string('year_ceo')->nullable();
            $table->string('mobile_notCeo')->nullable();
            $table->string('mobile_ceo')->nullable();
            $table->string('email_notCeo')->nullable();
            $table->string('email_ceo')->nullable();
            $table->string('link_notCeo')->nullable();
            $table->string('link_ceo')->nullable();
            $table->string('age_notCeo')->nullable();
            $table->string('age_ceo')->nullable();
            $table->string('education_notCeo')->nullable();
            $table->string('education_ceo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_represents');
    }
};
