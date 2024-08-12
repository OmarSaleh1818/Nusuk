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
        Schema::create('type_descriptions', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('description_id');

            // Define the composite primary key
            $table->primary(['user_id', 'description_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_descriptions');
    }
};
