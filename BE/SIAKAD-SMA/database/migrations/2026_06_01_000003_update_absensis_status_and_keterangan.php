<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom keterangan dulu
        Schema::table('absensis', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('status');
        });

        // Ubah enum status dari '0','1' menjadi hadir, izin, sakit, alpa
        // Pertama update data lama agar tidak hilang
        DB::statement("UPDATE absensis SET status = 'hadir' WHERE status = '1'");
        DB::statement("UPDATE absensis SET status = 'alpa' WHERE status = '0'");

        // Ubah tipe kolom status
        DB::statement("ALTER TABLE absensis MODIFY COLUMN status ENUM('hadir', 'izin', 'sakit', 'alpa') NOT NULL DEFAULT 'hadir'");
    }

    public function down(): void
    {
        // Kembalikan status ke enum lama
        DB::statement("UPDATE absensis SET status = '1' WHERE status = 'hadir'");
        DB::statement("UPDATE absensis SET status = '0' WHERE status != 'hadir'");
        DB::statement("ALTER TABLE absensis MODIFY COLUMN status ENUM('1', '0') NOT NULL DEFAULT '1'");

        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};
