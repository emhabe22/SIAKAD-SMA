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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        BK::create([
            'nama' => 'Budi Santoso',
            'nip' => '98888888',
            'alamat' => 'Jl. Konseling No. 1, Jakarta',
            'user_id' => $userBK->id,
            'no_telp' => '08123456790',
        ]);

        // ============ KELAS ============
        $kelas10A = Kelas::create(['id' => 1]);
        $kelas10B = Kelas::create(['id' => 2]);
        $kelas11A = Kelas::create(['id' => 3]);

        // ============ MAPEL ============
        $mapelMatematika = Mapel::create([
            'nama_mapel' => 'Matematika',
            'kelas_id' => $kelas10A->id,
        ]);

        $mapelFisika = Mapel::create([
            'nama_mapel' => 'Fisika',
            'kelas_id' => $kelas10A->id,
        ]);

        $mapelBahasaIndonesia = Mapel::create([
            'nama_mapel' => 'Bahasa Indonesia',
            'kelas_id' => $kelas10B->id,
        ]);

        // ============ GURU ============
        $userGuru1 = User::create([
            'username' => 'guru1',
            'nip' => '198501012010011001',
            'password' => Hash::make('guru123'),
            'role_id' => $roleGuru->id,
        ]);

        Guru::create([
            'nama' => 'Ahmad Rizki, S.Pd',
            'nip' => '198501012010011001',
            'alamat' => 'Jl. Pendidikan No. 10, Jakarta',
            'no_telp' => 81234567891,
            'user_id' => $userGuru1->id,
            'mapel_id' => $mapelMatematika->id,
        ]);

        $userGuru2 = User::create([
            'username' => 'guru2',
            'nip' => '198705152012012002',
            'password' => Hash::make('guru123'),
            'role_id' => $roleGuru->id,
        ]);

        Guru::create([
            'nama' => 'Siti Nurhaliza, S.Si',
            'nip' => '198705152012012002',
            'alamat' => 'Jl. Merdeka No. 25, Jakarta',
            'no_telp' => 81234567892,
            'user_id' => $userGuru2->id,
            'mapel_id' => $mapelFisika->id,
        ]);

        $userGuru3 = User::create([
            'username' => 'guru3',
            'nip' => '199001202015011003',
            'password' => Hash::make('guru123'),
            'role_id' => $roleGuru->id,
        ]);

        Guru::create([
            'nama' => 'Dedi Kurniawan, S.Pd',
            'nip' => '199001202015011003',
            'alamat' => 'Jl. Proklamasi No. 45, Jakarta',
            'no_telp' => 81234567893,
            'user_id' => $userGuru3->id,
            'mapel_id' => $mapelBahasaIndonesia->id,
        ]);

        // ============ SISWA ============
        $userSiswa1 = User::create([
            'username' => 'siswa1',
            'nisn' => '0051234567',
            'password' => Hash::make('siswa123'),
            'role_id' => $roleSiswa->id,
        ]);

        Siswa::create([
            'nama' => 'Andi Pratama',
            'nisn' => '0051234567',
            'alamat' => 'Jl. Gatot Subroto No. 15, Jakarta',
            'no_telp' => 81234567894,
            'user_id' => $userSiswa1->id,
            'kelas_id' => $kelas10A->id,
            'nama_wali' => 'Bapak Pratama',
        ]);

        $userSiswa2 = User::create([
            'username' => 'siswa2',
            'nisn' => '0051234568',
            'password' => Hash::make('siswa123'),
            'role_id' => $roleSiswa->id,
        ]);

        Siswa::create([
            'nama' => 'Dewi Lestari',
            'nisn' => '0051234568',
            'alamat' => 'Jl. Sudirman No. 20, Jakarta',
            'no_telp' => 81234567895,
            'user_id' => $userSiswa2->id,
            'kelas_id' => $kelas10A->id,
            'nama_wali' => 'Ibu Lestari',
        ]);

        $userSiswa3 = User::create([
            'username' => 'siswa3',
            'nisn' => '0051234569',
            'password' => Hash::make('siswa123'),
            'role_id' => $roleSiswa->id,
        ]);

        Siswa::create([
            'nama' => 'Rini Wijaya',
            'nisn' => '0051234569',
            'alamat' => 'Jl. Thamrin No. 30, Jakarta',
            'no_telp' => 81234567896,
            'user_id' => $userSiswa3->id,
            'kelas_id' => $kelas10B->id,
            'nama_wali' => 'Bapak Wijaya',
        ]);

        echo "✅ Seeder berhasil!\n\n";
        echo "=== Login Credentials ===\n";
        echo "Admin   - Username: admin   | Password: admin123\n";
        echo "BK      - Username: bk      | Password: bk123\n";
        echo "Guru    - Username: guru1   | Password: guru123 (NIP: 198501012010011001)\n";
        echo "        - Username: guru2   | Password: guru123 (NIP: 198705152012012002)\n";
        echo "        - Username: guru3   | Password: guru123 (NIP: 199001202015011003)\n";
        echo "Siswa   - Username: siswa1  | Password: siswa123 (NISN: 0051234567)\n";
        echo "        - Username: siswa2  | Password: siswa123 (NISN: 0051234568)\n";
        echo "        - Username: siswa3  | Password: siswa123 (NISN: 0051234569)\n";
    }
}

