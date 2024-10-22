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
        Schema::create('organization_private_indicators', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('opportunityData_id');
            $table->integer('private_indicator_id');
            $table->integer('unit_measure_number');
            $table->integer('actual_result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_private_indicators');
    }
};
