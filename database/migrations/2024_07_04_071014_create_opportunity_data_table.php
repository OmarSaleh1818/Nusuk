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
        Schema::create('opportunity_data', function (Blueprint $table) {
            $table->id();
            $table->integer('opportunity_id');
            $table->string('title');
            $table->text('about');
            $table->string('targeted_people');
            $table->string('conditions');
            $table->string('side');
            $table->date('date_publication');
            $table->date('deadline_apply');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('organization_number');
            $table->integer('status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_data');
    }
};
