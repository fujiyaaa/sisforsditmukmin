<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SiMukmin Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#F5F7F6] font-sans text-[#1F252D]">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="fixed left-0 top-0 z-40 h-screen w-72 overflow-hidden bg-gradient-to-b from-[#102B21] via-[#174B35] to-[#23704D] border-r border-white/10 shadow-[10px_0_35px_rgba(16,43,33,0.35)] flex flex-col justify-between">

    <!-- ORNAMENT -->
    <div class="absolute -top-24 -right-24 w-56 h-56 rounded-full bg-[#4D9A72]/30 blur-2xl"></div>
    <div class="absolute bottom-24 -left-24 w-56 h-56 rounded-full bg-[#DDF3E7]/10 blur-2xl"></div>

    <div class="relative z-10">

        <!-- LOGO -->
        <div class="px-6 py-7 border-b border-white/10">

            <div class="flex items-center gap-3">
                    <div class="w-12 h-12 shrink-0 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}"
                            alt="Logo SiMukmin"
                            class="max-w-full max-h-full object-contain mix-blend-multiply">
                    </div>

                <div>
                    <h1 class="text-2xl font-bold text-white leading-tight">
                        SiMukmin
                    </h1>

                    <p class="text-sm text-white/60 mt-0.5">
                        Admin Panel
                    </p>
                </div>

            </div>

        </div>

        <!-- NAVBAR -->
        <nav class="mt-6 px-4 space-y-1.5">

            <!-- DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Dashboard</span>
            </a>

            <!-- KELOLA AKUN -->
            <a href="{{ route('admin.akun.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.akun.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.akun.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Kelola Akun</span>
            </a>

            <!-- KELOLA KELAS -->
            <a href="/admin/kelas"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->is('admin/kelas*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->is('admin/kelas*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Kelola Kelas</span>
            </a>

            <!-- KELOLA GURU -->
            <a href="/admin/guru"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->is('admin/guru*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->is('admin/guru*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Kelola Guru</span>
            </a>


            <!-- KELOLA SISWA -->
            <a href="/admin/siswa"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->is('admin/siswa*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->is('admin/siswa*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Kelola Siswa</span>
            </a>

            <!-- HAK AKSES GURU -->
            <a href="{{ route('admin.hak-akses-guru.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.hak-akses-guru.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.hak-akses-guru.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Hak Akses Guru</span>
            </a>

            <!-- ABSENSI SISWA -->
            <a href="{{ route('admin.absensi.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.absensi.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.absensi.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Absensi Siswa</span>
            </a>

            <!-- MONITORING SHOLAT -->
            <a href="{{ route('admin.monitoring-sholat.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.monitoring-sholat.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.monitoring-sholat.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Monitoring Sholat</span>
            </a>

            <!-- LAPORAN -->
            <a href="{{ route('admin.laporan.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.laporan.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.laporan.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span class="leading-snug">Laporan Prestasi & Pelanggaran</span>
            </a>

            <!-- SETORAN QURAN -->
            <a href="{{ route('admin.setoran.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.setoran.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.setoran.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Setoran Quran</span>
            </a>

            <!-- REKAP PERSENTASE -->
            <a href="{{ route('admin.rekap-persentase.index') }}"
               class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                      {{ request()->routeIs('admin.rekap-persentase.*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.rekap-persentase.*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>
                <span>Rekap Persentase</span>
            </a>
        </nav>

    </div>

    <!-- PROFILE -->
    <div class="relative z-10 p-4 border-t border-white/10 bg-black/10">

        <div class="rounded-3xl bg-white/10 backdrop-blur-md border border-white/15 p-5 shadow-sm">

            <div class="flex items-center gap-3 mb-5">

                <div class="w-12 h-12 rounded-2xl bg-white text-[#2F7D55] flex items-center justify-center font-bold shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <h2 class="font-bold text-white truncate">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </h2>

                    <p class="text-sm text-white/60">
                        Administrator
                    </p>
                </div>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full bg-white text-red-600 px-5 py-3 rounded-2xl hover:bg-red-50 transition font-semibold text-left">
                    Logout
                </button>
            </form>

        </div>

    </div>

</aside>

    <!-- CONTENT WRAPPER -->
    <div class="ml-72 flex-1 min-h-screen">

        <!-- TOPBAR -->
        <header class="sticky top-0 z-30 bg-[#F5F7F6]/80 backdrop-blur border-b border-gray-100 px-8 py-5">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-400">
                        Selamat datang,
                    </p>

                    <h2 class="text-xl font-bold text-[#1F252D]">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </h2>
                </div>

                <div class="hidden md:flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="w-2.5 h-2.5 rounded-full bg-[#4D9A72]"></div>

                    <span class="text-sm font-semibold text-gray-600">
                        Admin Aktif
                    </span>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-8">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>
