<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SiMukmin Orang Tua</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#F4F7F5] font-sans text-[#1F252D]">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="fixed left-0 top-0 z-40 h-screen w-72 overflow-hidden bg-gradient-to-b from-[#102B21] via-[#174B35] to-[#23704D] border-r border-white/10 shadow-[10px_0_35px_rgba(16,43,33,0.35)] flex flex-col justify-between">

        <div>

            {{-- LOGO --}}
            <div class="px-7 py-7 border-b border-white/10">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 shrink-0 flex items-center justify-center rounded-2xl bg-white/10 overflow-hidden p-1">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo SiMukmin"
                             class="w-full h-full object-contain mix-blend-screen">
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight leading-tight">
                            SiMukmin
                        </h1>

                        <p class="text-xs text-white/70 mt-1">
                            Panel Orang Tua
                        </p>
                    </div>

                </div>

            </div>

            {{-- NAVIGATION --}}
            <nav class="px-4 py-6 space-y-2">

                <a href="{{ route('orangtua.dashboard') }}"
                   class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition
                   {{ request()->is('orangtua') || request()->is('orangtua/dashboard') ? 'bg-white text-[#1F6B4A] shadow-lg shadow-black/10 font-semibold' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2.5 h-2.5 rounded-full {{ request()->is('orangtua') || request()->is('orangtua/dashboard') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>Beranda</span>
                </a>

                <a href="{{ route('orangtua.monitoring') }}"
                   class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition
                   {{ request()->is('orangtua/monitoring*') ? 'bg-white text-[#1F6B4A] shadow-lg shadow-black/10 font-semibold' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2.5 h-2.5 rounded-full {{ request()->is('orangtua/monitoring*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>Setoran Quran</span>
                </a>

                <a href="{{ route('orangtua.ibadah-sholat.index') }}"
                   class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition
                   {{ request()->is('orangtua/ibadah-sholat*') ? 'bg-white text-[#1F6B4A] shadow-lg shadow-black/10 font-semibold' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2.5 h-2.5 rounded-full {{ request()->is('orangtua/ibadah-sholat*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>Monitoring Ibadah</span>
                </a>

                <a href="{{ url('/orangtua/absensi') }}"
                   class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition
                   {{ request()->is('orangtua/absensi*') ? 'bg-white text-[#1F6B4A] shadow-lg shadow-black/10 font-semibold' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2.5 h-2.5 rounded-full {{ request()->is('orangtua/absensi*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>Absensi</span>
                </a>

                <a href="{{ url('/orangtua/laporan') }}"
                   class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition
                   {{ request()->is('orangtua/laporan*') ? 'bg-white text-[#1F6B4A] shadow-lg shadow-black/10 font-semibold' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">

                    <span class="w-2.5 h-2.5 rounded-full {{ request()->is('orangtua/laporan*') ? 'bg-[#2F7D55]' : 'bg-white/35 group-hover:bg-white' }}"></span>

                    <span>Prestasi & Pelanggaran</span>
                </a>

            </nav>

        </div>

        {{-- PROFILE --}}
        <div class="p-4">

            <div class="rounded-3xl bg-white/10 backdrop-blur-md border border-white/15 p-5 shadow-sm">

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-2xl bg-white text-[#1F6B4A] flex items-center justify-center font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h2 class="font-semibold text-sm text-white truncate">
                            {{ Auth::user()->name ?? 'Orang Tua' }}
                        </h2>

                        <p class="text-xs text-white/60 mt-0.5">
                            Dashboard Orang Tua
                        </p>
                    </div>

                </div>

                @auth
                    <form method="POST" action="{{ url('/logout') }}" class="mt-5">
                        @csrf

                        <button type="submit"
                                class="w-full bg-white text-[#1F6B4A] hover:bg-[#F0F8F4] px-4 py-3 rounded-2xl text-sm font-semibold transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}"
                       class="block mt-5 text-center bg-white text-[#1F6B4A] hover:bg-[#F0F8F4] px-4 py-3 rounded-2xl text-sm font-semibold transition">
                        Login
                    </a>
                @endauth

            </div>

        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="ml-72 flex-1 min-h-screen">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-[#F4F7F5]/90 backdrop-blur-md border-b border-gray-100">

            <div class="px-8 py-5 flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-400">
                        Selamat datang,
                    </p>

                    <h2 class="text-xl font-bold text-[#1F252D]">
                        {{ Auth::user()->name ?? 'Orang Tua' }}
                    </h2>
                </div>

                <div class="flex items-center gap-4">

                    <div class="hidden sm:block text-right">
                        <p class="text-xs text-gray-400">
                            Hari Ini
                        </p>

                        <p class="text-sm font-semibold text-[#2F7D55]">
                            {{ now()->translatedFormat('d M Y') }}
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl px-5 py-3 shadow-sm border border-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#2F7D55]"></span>

                        <span class="text-sm font-semibold text-gray-700">
                            Orang Tua Aktif
                        </span>
                    </div>

                </div>

            </div>

        </header>

        {{-- PAGE CONTENT --}}
        <section class="p-8">
            @yield('content')
        </section>

    </main>

</div>

</body>
</html>
