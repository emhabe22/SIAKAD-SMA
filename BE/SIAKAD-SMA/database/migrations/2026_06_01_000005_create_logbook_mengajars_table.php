<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbook_mengajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absen_id')->constrained('absens')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');

            // Pre-filled dari absen.materi, bisa diedit
            $table->text('materi_pembelajaran')->nullable();

            // Field baru yang harus diisi guru
            $table->text('metode_pembelajaran')->nullable();
            $table->text('tugas_evaluasi')->nullable();

            // Status logbook
            $table->enum('status', ['draft', 'diserahkan'])->default('draft');
            $table->timestamp('diserahkan_at')->nullable();

            $table->timestamps();

            // One-to-one dengan absens
            $table->unique('absen_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook_mengajars');
    }
};
