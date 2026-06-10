<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pemanggilans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('bk_id');
            $table->string('nomor_surat')->nullable();
            $table->string('perihal');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_panggilan');
            $table->string('waktu_panggilan');
            $table->enum('status', ['draft', 'sent'])->default('draft');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            $table->foreign('bk_id')->references('id')->on('b_k_s')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pemanggilans');
    }
};
