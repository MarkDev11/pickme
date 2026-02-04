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
        Schema::create('body_analyses', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->integer('estimated_height')->comment('Height in cm');
            $table->integer('estimated_weight')->comment('Weight in kg');
            $table->integer('estimated_age')->comment('Age in years');
            $table->text('full_analysis')->nullable()->comment('AI description/notes');
            $table->timestamps();
            
            // Optional: Add indexes for better query performance
            $table->index('created_at');
            $table->index('estimated_height');
            $table->index('estimated_weight');
            $table->index('estimated_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_analyses');
    }
};