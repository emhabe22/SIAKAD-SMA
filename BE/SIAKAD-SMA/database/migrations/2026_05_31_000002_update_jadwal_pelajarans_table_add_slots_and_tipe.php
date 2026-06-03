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
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->foreignId('slot_id')
                ->nullable()
                ->after('id')
                ->constrained('jadwal_slots')
                ->nullOnDelete();
            $table->enum('tipe', ['mapel', 'kegiatan'])->default('mapel')->after('slot_id');
            $table->string('keterangan')->nullable();
        });

        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->foreignId('mapel_id')->nullable()->change();
            $table->foreignId('guru_id')->nullable()->change();
        });

        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->unique(['hari', 'slot_id', 'kelas_id'], 'jadwal_kelas_slot_unique');
            $table->unique(['hari', 'slot_id', 'guru_id'], 'jadwal_guru_slot_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->dropUnique('jadwal_kelas_slot_unique');
            $table->dropUnique('jadwal_guru_slot_unique');
            $table->dropColumn(['slot_id', 'tipe', 'keterangan']);
        });

        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->foreignId('mapel_id')->nullable(false)->change();
            $table->foreignId('guru_id')->nullable(false)->change();
        });
    }
};
