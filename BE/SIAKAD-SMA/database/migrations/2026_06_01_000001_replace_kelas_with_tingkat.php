<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('siswas') && !Schema::hasColumn('siswas', 'tingkat')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->enum('tingkat', ['X', 'XI', 'XII'])->nullable()->after('nisn');
            });
        }

        if (Schema::hasTable('absens') && !Schema::hasColumn('absens', 'tingkat')) {
            Schema::table('absens', function (Blueprint $table) {
                $table->enum('tingkat', ['X', 'XI', 'XII'])->nullable()->after('jam_selesai');
            });
        }

        if (Schema::hasTable('jadwal_pelajarans') && !Schema::hasColumn('jadwal_pelajarans', 'tingkat')) {
            Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                $table->enum('tingkat', ['X', 'XI', 'XII'])->nullable()->after('jam_selesai');
            });
        }

        if (Schema::hasTable('kelas')) {
            if (Schema::hasTable('siswas') && Schema::hasColumn('siswas', 'kelas_id')) {
                DB::statement("UPDATE siswas s JOIN kelas k ON s.kelas_id = k.id SET s.tingkat = k.tingkat WHERE s.tingkat IS NULL");
            }

            if (Schema::hasTable('absens') && Schema::hasColumn('absens', 'kelas_id')) {
                DB::statement("UPDATE absens a JOIN kelas k ON a.kelas_id = k.id SET a.tingkat = k.tingkat WHERE a.tingkat IS NULL");
            }

            if (Schema::hasTable('jadwal_pelajarans') && Schema::hasColumn('jadwal_pelajarans', 'kelas_id')) {
                DB::statement("UPDATE jadwal_pelajarans j JOIN kelas k ON j.kelas_id = k.id SET j.tingkat = k.tingkat WHERE j.tingkat IS NULL");
            }
        }

        if (Schema::hasTable('siswas')) {
            DB::table('siswas')->whereNull('tingkat')->update(['tingkat' => 'X']);
        }

        if (Schema::hasTable('absens')) {
            DB::table('absens')->whereNull('tingkat')->update(['tingkat' => 'X']);
        }

        if (Schema::hasTable('jadwal_pelajarans')) {
            DB::table('jadwal_pelajarans')->whereNull('tingkat')->update(['tingkat' => 'X']);
        }

        if (Schema::hasTable('siswas') && Schema::hasColumn('siswas', 'kelas_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            });
        }

        if (Schema::hasTable('absens') && Schema::hasColumn('absens', 'kelas_id')) {
            Schema::table('absens', function (Blueprint $table) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            });
        }

        if (Schema::hasTable('jadwal_pelajarans')) {
            try {
                Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                    $table->dropUnique('jadwal_kelas_slot_unique');
                });
            } catch (\Throwable $e) {
                // Ignore if the index does not exist.
            }

            if (Schema::hasColumn('jadwal_pelajarans', 'kelas_id')) {
                Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                    $table->dropForeign(['kelas_id']);
                    $table->dropColumn('kelas_id');
                });
            }

            Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                $table->unique(['hari', 'slot_id', 'tingkat'], 'jadwal_tingkat_slot_unique');
            });
        }

        Schema::dropIfExists('kelas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('kelas')) {
            Schema::create('kelas', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kelas');
                $table->enum('tingkat', ['X', 'XI', 'XII']);
                $table->enum('jurusan', ['MIPA', 'IPS', 'B.Indo']);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('siswas') && !Schema::hasColumn('siswas', 'kelas_id')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            });
        }

        if (Schema::hasTable('absens') && !Schema::hasColumn('absens', 'kelas_id')) {
            Schema::table('absens', function (Blueprint $table) {
                $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            });
        }

        if (Schema::hasTable('jadwal_pelajarans')) {
            try {
                Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                    $table->dropUnique('jadwal_tingkat_slot_unique');
                });
            } catch (\Throwable $e) {
                // Ignore if the index does not exist.
            }

            if (!Schema::hasColumn('jadwal_pelajarans', 'kelas_id')) {
                Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                    $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
                });
            }
        }

        if (Schema::hasTable('siswas') && Schema::hasColumn('siswas', 'tingkat')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->dropColumn('tingkat');
            });
        }

        if (Schema::hasTable('absens') && Schema::hasColumn('absens', 'tingkat')) {
            Schema::table('absens', function (Blueprint $table) {
                $table->dropColumn('tingkat');
            });
        }

        if (Schema::hasTable('jadwal_pelajarans') && Schema::hasColumn('jadwal_pelajarans', 'tingkat')) {
            Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                $table->dropColumn('tingkat');
            });
        }
    }
};
