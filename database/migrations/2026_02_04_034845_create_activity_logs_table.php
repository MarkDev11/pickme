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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang melakukan aksi? (Bisa User, bisa NULL jika Sistem/Bot)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Apa aksinya? (create, update, delete, login, export)
            $table->string('action'); 
            
            // Deskripsi singkat (Misal: "Menambahkan data pertumbuhan Budi")
            $table->string('description');
            
            // Relasi Polimorfik (Bisa nyambung ke tabel children, growth_records, users, dll)
            // Ini akan membuat kolom 'subject_type' dan 'subject_id' otomatis
            $table->nullableMorphs('subject'); 
            
            // Simpan detail perubahan (JSON) - Opsional, buat nyimpen data sebelum/sesudah edit
            $table->json('properties')->nullable();
            
            // Info teknis tambahan
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};