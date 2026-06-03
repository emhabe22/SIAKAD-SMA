<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->text('materi')->nullable()->after('pertemuan');
            $table->text('catatan_guru')->nullable()->after('materi');
            $table->timestamp('dibuka_pada')->nullable()->after('catatan_guru');
        });
    }

    public function down(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->dropColumn(['materi', 'catatan_guru', 'dibuka_pada']);
        });
    }
};
