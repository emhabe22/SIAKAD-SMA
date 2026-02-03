<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="user-profile">
            <img src="{{ asset('assets/images/user-avatar.png') }}" alt="Avatar {{ $role ?? 'User' }}">
            <div class="user-info">
                <h4>{{ $userName ?? 'User' }}</h4>
                <span class="role-badge">{{ $userRole ?? 'Role' }}</span>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul>
            @if($role === 'admin')
                <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="/admin/dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/siswa*') ? 'active' : '' }}">
                    <a href="/admin/siswa">
                        <i class="fas fa-users"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/guru*') ? 'active' : '' }}">
                    <a href="/admin/guru">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Data Guru</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/kelas*') ? 'active' : '' }}">
                    <a href="/admin/kelas">
                        <i class="fas fa-school"></i>
                        <span>Data Kelas</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/mapel*') ? 'active' : '' }}">
                    <a href="/admin/mapel">
                        <i class="fas fa-book"></i>
                        <span>Mata Pelajaran</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/jadwal-bk*') ? 'active' : '' }}">
                    <a href="/admin/jadwal-bk">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal BK</span>
                    </a>
                </li>
            @elseif($role === 'guru')
                <li class="{{ request()->is('guru/dashboard') ? 'active' : '' }}">
                    <a href="/guru/dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('guru/jadwal-mengajar*') ? 'active' : '' }}">
                    <a href="/guru/jadwal-mengajar">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal Mengajar</span>
                    </a>
                </li>
                <li class="{{ request()->is('guru/absensi*') ? 'active' : '' }}">
                    <a href="/guru/absensi">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Absensi Siswa</span>
                    </a>
                </li>
                <li class="{{ request()->is('guru/logbook*') ? 'active' : '' }}">
                    <a href="/guru/logbook">
                        <i class="fas fa-book"></i>
                        <span>Logbook</span>
                    </a>
                </li>
            @elseif($role === 'bk')
                <li class="{{ request()->is('bk/dashboard') ? 'active' : '' }}">
                    <a href="/bk/dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('bk/validasi*') ? 'active' : '' }}">
                    <a href="/bk/validasi">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi</span>
                    </a>
                </li>
                <li class="{{ request()->is('bk/surat-pemanggilan*') ? 'active' : '' }}">
                    <a href="/bk/surat-pemanggilan">
                        <i class="fas fa-envelope"></i>
                        <span>Surat Pemanggilan</span>
                    </a>
                </li>
                <li class="{{ request()->is('bk/feedback*') ? 'active' : '' }}">
                    <a href="/bk/feedback">
                        <i class="fas fa-comments"></i>
                        <span>Feedback</span>
                    </a>
                </li>
                <li class="{{ request()->is('bk/laporan*') ? 'active' : '' }}">
                    <a href="/bk/laporan">
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            @elseif($role === 'siswa')
                <li class="{{ request()->is('siswa/dashboard') ? 'active' : '' }}">
                    <a href="/siswa/dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('siswa/absensi*') ? 'active' : '' }}">
                    <a href="/siswa/absensi">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Absensi Saya</span>
                    </a>
                </li>
                <li class="{{ request()->is('siswa/bk*') ? 'active' : '' }}">
                    <a href="/siswa/bk">
                        <i class="fas fa-user-tie"></i>
                        <span>Bimbingan Konseling</span>
                    </a>
                </li>
                <li class="{{ request()->is('siswa/surat-pemanggilan*') ? 'active' : '' }}">
                    <a href="/siswa/surat-pemanggilan">
                        <i class="fas fa-envelope"></i>
                        <span>Surat Pemanggilan</span>
                    </a>
                </li>
            @endif
            
            <li class="divider"></li>
            <li>
                <a href="/logout" onclick="handleLogout(event)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
