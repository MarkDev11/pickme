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
        Schema::table('children', function (Blueprint $table) {
            // Kolom untuk menyimpan kesimpulan naratif dari AI
            $table->text('ai_summary')->nullable()->after('allergy_notes');
            
            // Kolom untuk menyimpan daftar saran tindakan (disimpan sebagai JSON text)
            $table->text('ai_recommendations')->nullable()->after('ai_summary');
            
            // Kolom timestamp manual untuk mencatat kapan terakhir generate summary
            $table->timestamp('summary_last_updated')->nullable()->after('ai_recommendations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn(['ai_summary', 'ai_recommendations', 'summary_last_updated']);
        });
    }
};