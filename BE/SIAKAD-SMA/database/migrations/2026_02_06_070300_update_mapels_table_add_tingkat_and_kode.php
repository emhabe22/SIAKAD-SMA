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
        Schema::table('mapels', function (Blueprint $table) {
            // Add new columns
            $table->string('kode_mapel')->unique()->after('id');
            $table->enum('tingkat', ['X', 'XI', 'XII'])->after('nama_mapel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            $table->dropColumn(['kode_mapel', 'tingkat']);
        });
    }
};
