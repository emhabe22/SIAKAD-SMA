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
        Schema::table('gurus', function (Blueprint $table) {
            // Drop the existing enum column and recreate as JSON
            $table->dropColumn('jabatan');
        });
        
        Schema::table('gurus', function (Blueprint $table) {
            $table->json('jabatan')->nullable()->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });
        
        Schema::table('gurus', function (Blueprint $table) {
            $table->enum('jabatan', ['Guru Mata Pelajaran', 'Kepala Sekolah', 'Wali Kelas', 'Guru BK'])->after('jenis_kelamin');
        });
    }
};
