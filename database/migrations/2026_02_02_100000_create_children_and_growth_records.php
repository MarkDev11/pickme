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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->decimal('birth_weight', 5, 2)->comment('Weight in kg');
            $table->decimal('birth_height', 5, 2)->comment('Height in cm');
            $table->enum('birth_type', ['normal', 'cesarean'])->default('normal');
            $table->string('photo')->nullable();
            $table->string('blood_type', 10)->nullable()->comment('A, B, AB, O with +/- rhesus factor');
            $table->text('health_notes')->nullable()->comment('Catatan kesehatan khusus');
            $table->text('allergy_notes')->nullable()->comment('Catatan alergi');
            $table->timestamps();
            
            // Indexes untuk performa query
            $table->index('user_id');
            $table->index('birth_date');
            $table->index(['user_id', 'created_at']);
        });

        // Growth Records Table
        Schema::create('growth_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('record_date');
            $table->integer('age_months')->comment('Age in months');
            
            // AI Estimated (from photo)
            $table->decimal('ai_estimated_weight', 5, 2)->nullable();
            $table->decimal('ai_estimated_height', 5, 2)->nullable();
            
            // Parent Confirmed/Edited
            $table->decimal('actual_weight', 5, 2)->comment('Weight in kg');
            $table->decimal('actual_height', 5, 2)->comment('Height in cm');
            $table->decimal('head_circumference', 5, 2)->nullable()->comment('Head circumference in cm');
            
            // Photo
            $table->string('photo_path');
            
            // AI Analysis
            $table->text('ai_analysis')->nullable();
            $table->text('growth_status')->nullable()->comment('Normal, Stunting, Wasting, etc');
            $table->text('recommendations')->nullable();
            $table->json('nutrition_advice')->nullable();
            $table->json('milestone_check')->nullable();
            
            // Z-Scores for WHO standards
            $table->decimal('weight_for_age_zscore', 5, 2)->nullable();
            $table->decimal('height_for_age_zscore', 5, 2)->nullable();
            $table->decimal('weight_for_height_zscore', 5, 2)->nullable();
            
            $table->text('parent_notes')->nullable();
            $table->timestamps();
            
            // Indexes untuk performa query
            $table->index('child_id');
            $table->index('user_id');
            $table->index('record_date');
            $table->index('age_months');
            $table->index(['child_id', 'record_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growth_records');
        Schema::dropIfExists('children');
    }
};