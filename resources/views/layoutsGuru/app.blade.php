<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SiMukmin Guru</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#F4F6F5] font-sans text-[#1F252D]">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="fixed left-0 top-0 z-40 h-screen w-72 bg-[#1F6B4A] text-white shadow-xl flex flex-col justify-between">

        <div>

            {{-- LOGO --}}
            <div class="p-6 border-b border-white/10">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl bg-white text-[#1F6B4A] flex items-center justify-center font-bold text-lg">
                        SM
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-white leading-tight">
                            SiMukmin
                        </h1>

                        <p class="text-sm text-white/70 mt-0.5">
                            Panel Guru
                        </p>
                    </div>

                </div>

            </div>

            {{-- NAVBAR --}}
            <nav class="px-4 py-6 space-y-2">

                {{-- MONITORING IBADAH --}}
                <a href="{{ url('/guru/monitoring-sholat') }}"
                   class="group flex items-center justify-between px-5 py-4 rounded-2xl transition
                   {{ request()->is('guru/monitoring-sholat*') ? 'bg-white text-[#1F6B4A] font-bold shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                    <span class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full transition
                            {{ request()->is('guru/monitoring-sholat*') ? 'bg-[#1F6B4A]' : 'bg-white/40 group-hover:bg-white' }}">
                        </span>

                        <span>
                            Monitoring Ibadah
                        </span>
                    </span>

                    @if(request()->is('guru/monitoring-sholat*'))
                        <span class="w-1.5 h-8 rounded-full bg-[#1F6B4A]"></span>
                    @endif

                </a>

                {{-- SETORAN QURAN --}}
                <a href="{{ url('/guru/setoran') }}"
                   class="group flex items-center justify-between px-5 py-4 rounded-2xl transition
                   {{ request()->is('guru/setoran*') ? 'bg-white text-[#1F6B4A] font-bold shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                    <span class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full transition
                            {{ request()->is('guru/setoran*') ? 'bg-[#1F6B4A]' : 'bg-white/40 group-hover:bg-white' }}">
                        </span>

                        <span>
                            Setoran Quran
                        </span>
                    </span>

                    @if(request()->is('guru/setoran*'))
                        <span class="w-1.5 h-8 rounded-full bg-[#1F6B4A]"></span>
                    @endif

                </a>

                {{-- REKAP ABSENSI --}}
                <a href="{{ route('guru.absensi.index') }}"
                   class="group flex items-center justify-between px-5 py-4 rounded-2xl transition
                   {{ request()->routeIs('guru.absensi.*') ? 'bg-white text-[#1F6B4A] font-bold shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                    <span class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full transition
                            {{ request()->routeIs('guru.absensi.*') ? 'bg-[#1F6B4A]' : 'bg-white/40 group-hover:bg-white' }}">
                        </span>

                        <span>
                            Rekap Absensi
                        </span>
                    </span>

                    @if(request()->routeIs('guru.absensi.*'))
                        <span class="w-1.5 h-8 rounded-full bg-[#1F6B4A]"></span>
                    @endif

                </a>

                {{-- LAPORAN --}}
                <a href="{{ url('/guru/laporan-prestasi-pelanggaran') }}"
                   class="group flex items-center justify-between px-5 py-4 rounded-2xl transition
                   {{ request()->is('guru/laporan-prestasi-pelanggaran*') ? 'bg-white text-[#1F6B4A] font-bold shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                    <span class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full transition
                            {{ request()->is('guru/laporan-prestasi-pelanggaran*') ? 'bg-[#1F6B4A]' : 'bg-white/40 group-hover:bg-white' }}">
                        </span>

                        <span>
                            Laporan Prestasi & Pelanggaran
                        </span>
                    </span>

                    @if(request()->is('guru/laporan-prestasi-pelanggaran*'))
                        <span class="w-1.5 h-8 rounded-full bg-[#1F6B4A]"></span>
                    @endif

                </a>

            </nav>

        </div>

        {{-- PROFILE --}}
        <div class="p-4 border-t border-white/10">

            <div class="rounded-[1.5rem] bg-[#16583B] border border-white/10 p-5">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl bg-white text-[#1F6B4A] flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h2 class="font-bold text-white truncate">
                            {{ Auth::user()->name ?? 'Guru' }}
                        </h2>

                        <p class="text-sm text-white/70 mt-0.5">
                            Dashboard Guru
                        </p>
                    </div>

                </div>

                @auth
                    <form method="POST" action="{{ url('/logout') }}" class="mt-5">
                        @csrf

                        <button type="submit"
                                class="w-full bg-white/10 text-white hover:bg-white/20 px-4 py-3 rounded-2xl text-sm font-semibold transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}"
                       class="block mt-5 text-center bg-white text-[#1F6B4A] hover:bg-white/90 px-4 py-3 rounded-2xl text-sm font-semibold transition">
                        Login
                    </a>
                @endauth

            </div>

        </div>

    </aside>

    {{-- CONTENT WRAPPER --}}
    <div class="ml-72 flex-1 min-h-screen">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-[#F4F6F5]/90 backdrop-blur-md border-b border-gray-100">

            <div class="px-8 py-5 flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-400">
                        Selamat datang,
                    </p>

                    <h2 class="text-xl font-bold text-[#1F252D]">
                        {{ Auth::user()->name ?? 'Guru' }}
                    </h2>
                </div>

                <div class="flex items-center gap-3">

                    <div class="hidden md:block text-right">
                        <p class="text-sm text-gray-400">
                            Hari Ini
                        </p>

                        <p class="text-sm font-bold text-[#2F7D55]">
                            {{ now()->format('d M Y') }}
                        </p>
                    </div>

                    <div class="inline-flex items-center gap-2 bg-white border border-gray-100 rounded-2xl px-5 py-3 shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#2F7D55]"></span>

                        <span class="text-sm font-semibold text-gray-600">
                            Guru Aktif
                        </span>
                    </div>

                </div>

            </div>

        </header>

        {{-- MAIN CONTENT --}}
        <main class="p-8">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
