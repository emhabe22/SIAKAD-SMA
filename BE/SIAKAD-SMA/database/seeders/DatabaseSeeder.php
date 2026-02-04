<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\BK;
use App\Models\Point;
use App\Models\JadwalPelajaran;
use App\Models\PelanggaranSiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Roles
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleBK = Role::create(['name' => 'BK']);
        $roleGuru = Role::create(['name' => 'Guru']);
        $roleSiswa = Role::create(['name' => 'Siswa']);

        // ============ ADMIN ============
        $userAdmin = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role_id' => $roleAdmin->id,
        ]);

        Admin::create([
            'nama' => 'Administrator',
            'user_id' => $userAdmin->id,
            'no_telp' => '08123456789',
        ]);

        // ============ BK ============
        $userBK = User::create([
            'username' => 'bk',
            'password' => Hash::make('bk123'),
            'role_id' => $roleBK->id,
        ]);

        $bk = BK::create([
            'nama' => 'Budi Santoso, S.Pd',
            'nip' => '198888888888',
            'alamat' => 'Jl. Konseling No. 1, Jakarta',
            'user_id' => $userBK->id,
            'no_telp' => '08123456790',
        ]);

        // ============ KELAS ============
        $kelas10IPA1 = Kelas::create([
            'nama_kelas' => 'X IPA 1',
            'tingkat' => '10',
            'jurusan' => 'IPA'
        ]);
        
        $kelas10IPA2 = Kelas::create([
            'nama_kelas' => 'X IPA 2',
            'tingkat' => '10',
            'jurusan' => 'IPA'
        ]);
        
        $kelas11IPA1 = Kelas::create([
            'nama_kelas' => 'XI IPA 1',
            'tingkat' => '11',
            'jurusan' => 'IPA'
        ]);
        
        $kelas12IPA1 = Kelas::create([
            'nama_kelas' => 'XII IPA 1',
            'tingkat' => '12',
            'jurusan' => 'IPA'
        ]);

        // ============ MAPEL (Mata Pelajaran SMA) ============
        $mapelMatematika = Mapel::create(['nama_mapel' => 'Matematika']);
        $mapelFisika = Mapel::create(['nama_mapel' => 'Fisika']);
        $mapelKimia = Mapel::create(['nama_mapel' => 'Kimia']);
        $mapelBiologi = Mapel::create(['nama_mapel' => 'Biologi']);
        $mapelBIndo = Mapel::create(['nama_mapel' => 'Bahasa Indonesia']);
        $mapelBInggris = Mapel::create(['nama_mapel' => 'Bahasa Inggris']);
        $mapelSejarah = Mapel::create(['nama_mapel' => 'Sejarah']);
        $mapelEkonomi = Mapel::create(['nama_mapel' => 'Ekonomi']);
        $mapelPJOK = Mapel::create(['nama_mapel' => 'PJOK']);

        // ============ GURU ============
        $userGuru1 = User::create([
            'username' => 'guru1',
            'password' => Hash::make('guru123'),
            'role_id' => $roleGuru->id,
        ]);

        $guru1 = Guru::create([
            'nama' => 'Ahmad Rizki, S.Pd',
            'nip' => '198501012010011001',
            'alamat' => 'Jl. Pendidikan No. 10, Jakarta',
            'no_telp' => '081234567891',
            'user_id' => $userGuru1->id,
        ]);

        $userGuru2 = User::create([
            'username' => 'guru2',
            'password' => Hash::make('guru123'),
            'role_id' => $roleGuru->id,
        ]);

        $guru2 = Guru::create([
            'nama' => 'Siti Nurhaliza, S.Si',
            'nip' => '198705152012012002',
            'alamat' => 'Jl. Merdeka No. 25, Jakarta',
            'no_telp' => '081234567892',
            'user_id' => $userGuru2->id,
        ]);

        $userGuru3 = User::create([
            'username' => 'guru3',
            'password' => Hash::make('guru123'),
            'role_id' => $roleGuru->id,
        ]);

        $guru3 = Guru::create([
            'nama' => 'Dedi Kurniawan, S.Pd',
            'nip' => '199001202015011003',
            'alamat' => 'Jl. Proklamasi No. 45, Jakarta',
            'no_telp' => '081234567893',
            'user_id' => $userGuru3->id,
        ]);

        // ============ GURU-MAPEL (Many-to-Many) ============
        // Guru 1 mengajar Matematika dan Fisika
        $guru1->mapels()->attach([$mapelMatematika->id, $mapelFisika->id]);
        
        // Guru 2 mengajar Kimia dan Biologi
        $guru2->mapels()->attach([$mapelKimia->id, $mapelBiologi->id]);
        
        // Guru 3 mengajar Bahasa Indonesia dan Bahasa Inggris
        $guru3->mapels()->attach([$mapelBIndo->id, $mapelBInggris->id]);

        // ============ SISWA ============
        $userSiswa1 = User::create([
            'username' => 'siswa1',
            'password' => Hash::make('siswa123'),
            'role_id' => $roleSiswa->id,
        ]);

        $siswa1 = Siswa::create([
            'nama' => 'Andi Pratama',
            'nisn' => '0051234567',
            'alamat' => 'Jl. Gatot Subroto No. 15, Jakarta',
            'no_telp' => '081234567894',
            'user_id' => $userSiswa1->id,
            'kelas_id' => $kelas10IPA1->id,
            'nama_wali' => 'Bapak Pratama',
        ]);

        $userSiswa2 = User::create([
            'username' => 'siswa2',
            'password' => Hash::make('siswa123'),
            'role_id' => $roleSiswa->id,
        ]);

        $siswa2 = Siswa::create([
            'nama' => 'Dewi Lestari',
            'nisn' => '0051234568',
            'alamat' => 'Jl. Sudirman No. 20, Jakarta',
            'no_telp' => '081234567895',
            'user_id' => $userSiswa2->id,
            'kelas_id' => $kelas10IPA1->id,
            'nama_wali' => 'Ibu Lestari',
        ]);

        $userSiswa3 = User::create([
            'username' => 'siswa3',
            'password' => Hash::make('siswa123'),
            'role_id' => $roleSiswa->id,
        ]);

        $siswa3 = Siswa::create([
            'nama' => 'Rini Wijaya',
            'nisn' => '0051234569',
            'alamat' => 'Jl. Thamrin No. 30, Jakarta',
            'no_telp' => '081234567896',
            'user_id' => $userSiswa3->id,
            'kelas_id' => $kelas10IPA2->id,
            'nama_wali' => 'Bapak Wijaya',
        ]);

        // ============ JADWAL PELAJARAN ============
        // Jadwal untuk Kelas X IPA 1
        JadwalPelajaran::create([
            'hari' => 'Senin',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'kelas_id' => $kelas10IPA1->id,
            'mapel_id' => $mapelMatematika->id,
            'guru_id' => $guru1->id,
            'ruangan' => 'R.301',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Senin',
            'jam_mulai' => '08:30',
            'jam_selesai' => '10:00',
            'kelas_id' => $kelas10IPA1->id,
            'mapel_id' => $mapelFisika->id,
            'guru_id' => $guru1->id,
            'ruangan' => 'Lab Fisika',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Senin',
            'jam_mulai' => '10:15',
            'jam_selesai' => '11:45',
            'kelas_id' => $kelas10IPA1->id,
            'mapel_id' => $mapelBIndo->id,
            'guru_id' => $guru3->id,
            'ruangan' => 'R.301',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Selasa',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'kelas_id' => $kelas10IPA1->id,
            'mapel_id' => $mapelKimia->id,
            'guru_id' => $guru2->id,
            'ruangan' => 'Lab Kimia',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Selasa',
            'jam_mulai' => '08:30',
            'jam_selesai' => '10:00',
            'kelas_id' => $kelas10IPA1->id,
            'mapel_id' => $mapelBiologi->id,
            'guru_id' => $guru2->id,
            'ruangan' => 'R.302',
        ]);

        // ============ POINT PELANGGARAN ============
        $pointTerlambat = Point::create([
            'nama' => 'Terlambat',
            'nilai' => -10,
        ]);

        $pointBolos = Point::create([
            'nama' => 'Bolos/Tidak Hadir Tanpa Keterangan',
            'nilai' => -30,
        ]);

        $pointSeragam = Point::create([
            'nama' => 'Tidak Memakai Seragam Lengkap',
            'nilai' => -20,
        ]);

        $pointMerokok = Point::create([
            'nama' => 'Merokok di Lingkungan Sekolah',
            'nilai' => -50,
        ]);

        $pointBertengkar = Point::create([
            'nama' => 'Berkelahi/Bertengkar',
            'nilai' => -40,
        ]);

        // ============ PELANGGARAN SISWA (Sample Data) ============
        PelanggaranSiswa::create([
            'siswa_id' => $siswa1->id,
            'point_id' => $pointTerlambat->id,
            'bk_id' => $bk->id,
            'tanggal' => '2026-02-01',
            'keterangan' => 'Terlambat masuk kelas pukul 07:15',
        ]);

        PelanggaranSiswa::create([
            'siswa_id' => $siswa2->id,
            'point_id' => $pointBolos->id,
            'bk_id' => $bk->id,
            'tanggal' => '2026-02-03',
            'keterangan' => 'Tidak masuk tanpa keterangan pada mata pelajaran Fisika',
        ]);

        echo "✅ Seeder berhasil!\n\n";
        echo "=== Login Credentials ===\n";
        echo "Admin   - Username: admin   | Password: admin123\n";
        echo "BK      - Username: bk      | Password: bk123\n";
        echo "Guru 1  - Username: guru1   | Password: guru123 (Matematika & Fisika)\n";
        echo "Guru 2  - Username: guru2   | Password: guru123 (Kimia & Biologi)\n";
        echo "Guru 3  - Username: guru3   | Password: guru123 (B. Indonesia & B. Inggris)\n";
        echo "Siswa 1 - Username: siswa1  | Password: siswa123 (X IPA 1)\n";
        echo "Siswa 2 - Username: siswa2  | Password: siswa123 (X IPA 1)\n";
        echo "Siswa 3 - Username: siswa3  | Password: siswa123 (X IPA 2)\n";
        echo "\n=== Info Tambahan ===\n";
        echo "- Total Kelas: 4 (X IPA 1, X IPA 2, XI IPA 1, XII IPA 1)\n";
        echo "- Total Mapel: 9\n";
        echo "- Jadwal Pelajaran: 5 jadwal untuk X IPA 1\n";
        echo "- Point Pelanggaran: 5 jenis\n";
    }
}

