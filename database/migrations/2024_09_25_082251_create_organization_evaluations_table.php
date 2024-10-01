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
        Schema::create('organization_evaluations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('opportunityData_id');
            $table->integer('evaluation_aspect_id');
            $table->integer('evaluation_choice_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_evaluations');
    }
};
