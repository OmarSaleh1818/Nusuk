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
        Schema::create('staff_degrees', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('degree_id');
            $table->integer('operation_id');
            $table->integer('engaged')->nullable();
            $table->integer('not_engaged')->nullable();
            $table->integer('certified')->nullable();
            $table->integer('not_certified')->nullable();
            $table->integer('office_work')->nullable();
            $table->integer('field_work')->nullable();
            $table->integer('mixed_work')->nullable();
            $table->boolean('is_volunteer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_degrees');
    }
};
