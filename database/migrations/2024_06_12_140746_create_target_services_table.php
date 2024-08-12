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
        Schema::create('target_services', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('service_id');
            $table->string('service_name')->nullable();

            // Define the composite primary key
            $table->primary(['user_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_services');
    }
};
