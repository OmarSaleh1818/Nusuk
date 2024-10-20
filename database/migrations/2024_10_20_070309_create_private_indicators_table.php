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
        Schema::create('private_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('indicator_title');
            $table->string('unit_measure');
            $table->string('indicator_nature');
            $table->string('targeted_period');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_indicators');
    }
};
