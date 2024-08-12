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
        Schema::create('service_implementeds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('business_id');
            $table->integer('indicator_id');
            $table->integer('seasonal_service');
            $table->integer('ongoing_service');
            $table->integer('initiatives');
            $table->integer('events');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_implementeds');
    }
};
