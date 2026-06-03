<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absen_log_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absen_id')->constrained('absens')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('aksi', ['sesi_dibuat', 'absen_diisi', 'absen_diubah']);
            $table->text('deskripsi')->nullable();
            $table->json('data_sebelum')->nullable();
            $table->json('data_sesudah')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
            // Tidak ada updated_at karena log bersifat immutable
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absen_log_books');
    }
};
