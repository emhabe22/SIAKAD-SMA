<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\BK;
use App\Models\Point;
use App\Models\JadwalSlot;
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

        // ============ MAPEL (Mata Pelajaran SMA) ============
        $mapelMatematika = Mapel::create([
            'nama_mapel' => 'Matematika',
            'kode_mapel' => 'X-MAT',
            'tingkat' => 'X',
        ]);
        $mapelFisika = Mapel::create([
            'nama_mapel' => 'Fisika',
            'kode_mapel' => 'X-FIS',
            'tingkat' => 'X',
        ]);
        $mapelKimia = Mapel::create([
            'nama_mapel' => 'Kimia',
            'kode_mapel' => 'X-KIM',
            'tingkat' => 'X',
        ]);
        $mapelBiologi = Mapel::create([
            'nama_mapel' => 'Biologi',
            'kode_mapel' => 'X-BIO',
            'tingkat' => 'X',
        ]);
        $mapelBIndo = Mapel::create([
            'nama_mapel' => 'Bahasa Indonesia',
            'kode_mapel' => 'X-BIN',
            'tingkat' => 'X',
        ]);
        $mapelBInggris = Mapel::create([
            'nama_mapel' => 'Bahasa Inggris',
            'kode_mapel' => 'X-BING',
            'tingkat' => 'X',
        ]);
        $mapelSejarah = Mapel::create([
            'nama_mapel' => 'Sejarah',
            'kode_mapel' => 'X-SEJ',
            'tingkat' => 'X',
        ]);
        $mapelEkonomi = Mapel::create([
            'nama_mapel' => 'Ekonomi',
            'kode_mapel' => 'X-EKO',
            'tingkat' => 'X',
        ]);
        $mapelPJOK = Mapel::create([
            'nama_mapel' => 'PJOK',
            'kode_mapel' => 'X-PJOK',
            'tingkat' => 'X',
        ]);

        // ============ JADWAL SLOTS =========
        if (JadwalSlot::count() === 0) {
            $slots = [
                [
                    'jam_ke' => null,
                    'jam_mulai' => '06:50',
                    'jam_selesai' => '07:00',
                    'label' => 'Apel Pagi',
                    'tipe' => 'kegiatan',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 1,
                    'jam_mulai' => '07:00',
                    'jam_selesai' => '07:45',
                    'label' => 'Jam 1',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 2,
                    'jam_mulai' => '07:45',
                    'jam_selesai' => '08:30',
                    'label' => 'Jam 2',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 3,
                    'jam_mulai' => '08:30',
                    'jam_selesai' => '09:15',
                    'label' => 'Jam 3',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 4,
                    'jam_mulai' => '09:15',
                    'jam_selesai' => '10:00',
                    'label' => 'Jam 4',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => null,
                    'jam_mulai' => '10:00',
                    'jam_selesai' => '10:30',
                    'label' => 'Istirahat',
                    'tipe' => 'kegiatan',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 5,
                    'jam_mulai' => '10:30',
                    'jam_selesai' => '11:15',
                    'label' => 'Jam 5',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 6,
                    'jam_mulai' => '11:15',
                    'jam_selesai' => '12:00',
                    'label' => 'Jam 6',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => null,
                    'jam_mulai' => '12:00',
                    'jam_selesai' => '12:45',
                    'label' => 'Shalat Dzuhur & Istirahat',
                    'tipe' => 'kegiatan',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 7,
                    'jam_mulai' => '12:45',
                    'jam_selesai' => '13:30',
                    'label' => 'Jam 7',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 8,
                    'jam_mulai' => '13:30',
                    'jam_selesai' => '14:15',
                    'label' => 'Jam 8',
                    'tipe' => 'mapel',
                    'hari' => null,
                ],
                [
                    'jam_ke' => null,
                    'jam_mulai' => '14:15',
                    'jam_selesai' => '15:15',
                    'label' => 'Ekstrakurikuler',
                    'tipe' => 'kegiatan',
                    'hari' => null,
                ],
                [
                    'jam_ke' => 1,
                    'jam_mulai' => '07:00',
                    'jam_selesai' => '07:30',
                    'label' => 'Rotibul Haddad',
                    'tipe' => 'kegiatan',
                    'hari' => 'Jumat',
                ],
                [
                    'jam_ke' => 2,
                    'jam_mulai' => '07:30',
                    'jam_selesai' => '08:15',
                    'label' => 'Jam 2',
                    'tipe' => 'mapel',
                    'hari' => 'Jumat',
                ],
                [
                    'jam_ke' => 3,
                    'jam_mulai' => '08:15',
                    'jam_selesai' => '09:00',
                    'label' => 'Jam 3',
                    'tipe' => 'mapel',
                    'hari' => 'Jumat',
                ],
                [
                    'jam_ke' => 4,
                    'jam_mulai' => '09:00',
                    'jam_selesai' => '09:45',
                    'label' => 'Jam 4',
                    'tipe' => 'mapel',
                    'hari' => 'Jumat',
                ],
                [
                    'jam_ke' => 5,
                    'jam_mulai' => '09:45',
                    'jam_selesai' => '10:30',
                    'label' => 'Jam 5',
                    'tipe' => 'mapel',
                    'hari' => 'Jumat',
                ],
            ];

            foreach ($slots as &$slot) {
                $slot['created_at'] = now();
                $slot['updated_at'] = now();
            }
            unset($slot);

            JadwalSlot::insert($slots);
        }

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
            'tingkat' => 'X',
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
            'tingkat' => 'X',
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
            'tingkat' => 'X',
            'nama_wali' => 'Bapak Wijaya',
        ]);

        // ============ JADWAL PELAJARAN ============
        // Jadwal untuk Tingkat X
        JadwalPelajaran::create([
            'hari' => 'Senin',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'tingkat' => 'X',
            'mapel_id' => $mapelMatematika->id,
            'guru_id' => $guru1->id,
            'ruangan' => 'R.301',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Senin',
            'jam_mulai' => '08:30',
            'jam_selesai' => '10:00',
            'tingkat' => 'X',
            'mapel_id' => $mapelFisika->id,
            'guru_id' => $guru1->id,
            'ruangan' => 'Lab Fisika',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Senin',
            'jam_mulai' => '10:15',
            'jam_selesai' => '11:45',
            'tingkat' => 'X',
            'mapel_id' => $mapelBIndo->id,
            'guru_id' => $guru3->id,
            'ruangan' => 'R.301',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Selasa',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'tingkat' => 'X',
            'mapel_id' => $mapelKimia->id,
            'guru_id' => $guru2->id,
            'ruangan' => 'Lab Kimia',
        ]);

        JadwalPelajaran::create([
            'hari' => 'Selasa',
            'jam_mulai' => '08:30',
            'jam_selesai' => '10:00',
            'tingkat' => 'X',
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
        echo "Siswa 1 - Username: siswa1  | Password: siswa123 (Tingkat X)\n";
        echo "Siswa 2 - Username: siswa2  | Password: siswa123 (Tingkat X)\n";
        echo "Siswa 3 - Username: siswa3  | Password: siswa123 (Tingkat X)\n";
        echo "\n=== Info Tambahan ===\n";
        echo "- Tingkat tersedia: X, XI, XII\n";
        echo "- Total Mapel: 9\n";
        echo "- Jadwal Pelajaran: 5 jadwal untuk Tingkat X\n";
        echo "- Point Pelanggaran: 5 jenis\n";
    }
}

