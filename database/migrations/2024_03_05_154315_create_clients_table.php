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
        Schema::create('clients', function (Blueprint $table) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email')->unique();
                $table->string('phone_number')->nullable();
                $table->string('company_name')->nullable();
                $table->string('job_title')->nullable();
                $table->text('address')->nullable();
                $table->string('industry')->nullable();
                $table->string('lead_source')->nullable();
                $table->text('notes')->nullable();
                $table->json('social_media_profiles')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
                $table->timestamps();
            });
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
