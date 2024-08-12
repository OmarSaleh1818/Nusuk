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
        Schema::create('staff_others', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('benefit_male')->nullable();
            $table->integer('benefit_female')->nullable();
            $table->integer('benefit_total')->nullable();
            $table->integer('fees_male')->nullable();
            $table->integer('fees_female')->nullable();
            $table->integer('fees_total')->nullable();
            $table->integer('free_male')->nullable();
            $table->integer('free_female')->nullable();
            $table->integer('free_total')->nullable();
            $table->integer('expenses_male')->nullable();
            $table->integer('expenses_female')->nullable();
            $table->integer('expenses_total')->nullable();
            $table->integer('value_male')->nullable();
            $table->integer('value_female')->nullable();
            $table->integer('value_total')->nullable();
            $table->integer('trainees_male')->nullable();
            $table->integer('trainees_female')->nullable();
            $table->integer('trainees_total')->nullable();
            $table->integer('graduates_male')->nullable();
            $table->integer('graduates_female')->nullable();
            $table->integer('graduates_total')->nullable();
            $table->integer('fullTime_male')->nullable();
            $table->integer('fullTime_female')->nullable();
            $table->integer('fullTime_total')->nullable();
            $table->integer('partTime_male')->nullable();
            $table->integer('partTime_female')->nullable();
            $table->integer('partTime_total')->nullable();
            $table->integer('consulting_male')->nullable();
            $table->integer('consulting_female')->nullable();
            $table->integer('consulting_total')->nullable();
            $table->integer('management_male')->nullable();
            $table->integer('management_female')->nullable();
            $table->integer('management_total')->nullable();
            $table->integer('workers_male')->nullable();
            $table->integer('workers_female')->nullable();
            $table->integer('workers_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_others');
    }
};
