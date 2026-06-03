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
        Schema::create('jadwal_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('jam_ke')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('label')->nullable();
            $table->enum('tipe', ['mapel', 'kegiatan'])->default('mapel');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])->nullable();
            $table->timestamps();

            $table->index(['hari', 'jam_mulai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_slots');
    }
};
