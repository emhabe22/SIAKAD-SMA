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
        Schema::table('absens', function (Blueprint $table) {
            $table->time('jam_mulai')->after('tanggal');
            $table->time('jam_selesai')->after('jam_mulai');
            $table->foreignId('kelas_id')->after('jam_selesai')->constrained('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn(['jam_mulai', 'jam_selesai', 'kelas_id']);
        });
    }
};
