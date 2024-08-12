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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('organization_email');
            $table->string('license_number');
            $table->string('organization_region');
            $table->string('organization_city');
            $table->string('manager_name');
            $table->string('manager_email');
            $table->string('manager_mobile');
            $table->string('contact_name');
            $table->string('contact_mobile');
            $table->string('contact_job_title')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
