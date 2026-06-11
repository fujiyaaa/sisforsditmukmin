<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SiMukmin Guru</title>

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

                    <div class="w-12 h-12 rounded-2xl bg-white text-[#2F7D55] flex items-center justify-center font-bold text-lg shadow-sm">
                        SM
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-white leading-tight">
                            SiMukmin
                        </h1>

                        <p class="text-sm text-white/60 mt-0.5">
                            Panel Guru
                        </p>
                    </div>

                </div>

            </div>

            <!-- NAVBAR -->
            <nav class="mt-6 px-4 space-y-1.5">

                <a href="{{ url('/guru/dashboard') }}"
                   class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('guru/dashboard*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('guru/dashboard*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>
                        Dashboard
                    </span>
                </a>

                <!-- MONITORING IBADAH -->
                <a href="{{ url('/guru/monitoring-sholat') }}"
                   class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('guru/monitoring-sholat*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('guru/monitoring-sholat*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>
                        Monitoring Ibadah
                    </span>
                </a>

                <!-- SETORAN QURAN -->
                <a href="{{ url('/guru/setoran') }}"
                   class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('guru/setoran*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('guru/setoran*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>
                        Setoran Quran
                    </span>
                </a>

                <!-- REKAP ABSENSI -->
                <a href="{{ url('/guru/rekap-absensi') }}"
                   class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('guru/rekap-absensi*') || request()->is('guru/absensi*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('guru/rekap-absensi*') || request()->is('guru/absensi*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>
                        Rekap Absensi
                    </span>
                </a>

                <!-- LAPORAN PRESTASI & PELANGGARAN -->
                <a href="{{ url('/guru/laporan-prestasi-pelanggaran') }}"
                   class="group relative flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('guru/laporan-prestasi-pelanggaran*') ? 'bg-white text-[#1F6B4A] font-semibold shadow-lg shadow-black/10' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('guru/laporan-prestasi-pelanggaran*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span class="leading-snug">
                        Laporan Prestasi & Pelanggaran
                    </span>
                </a>

            </nav>

        </div>

        <!-- PROFILE -->
        <div class="relative z-10 p-4 border-t border-white/10 bg-black/10">

            <div class="rounded-3xl bg-white/10 backdrop-blur-md border border-white/15 p-5 shadow-sm">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-2xl bg-white text-[#2F7D55] flex items-center justify-center font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h2 class="font-bold text-white truncate">
                            {{ Auth::user()->name ?? 'Guru' }}
                        </h2>

                        <p class="text-sm text-white/60">
                            Dashboard Guru
                        </p>
                    </div>

                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full bg-white text-red-600 px-5 py-3 rounded-2xl hover:bg-red-50 transition font-semibold text-center">
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
                        {{ Auth::user()->name ?? 'Guru' }}
                    </h2>
                </div>

                <div class="hidden md:flex items-center gap-6">

                    <div class="text-right">
                        <p class="text-sm text-gray-400">
                            Hari Ini
                        </p>

                        <h3 class="text-sm font-bold text-[#2F7D55]">
                            {{ now()->translatedFormat('d M Y') }}
                        </h3>
                    </div>

                    <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm">

                        <div class="w-2.5 h-2.5 rounded-full bg-[#4D9A72]"></div>

                        <span class="text-sm font-semibold text-gray-600">
                            Guru Aktif
                        </span>

                    </div>

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