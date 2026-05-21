<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SiMukmin Orang Tua</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#F3F3F3] font-sans">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-72 h-screen fixed bg-[#4D9A72] text-white flex flex-col justify-between shadow-2xl">

        <div>
            <!-- LOGO -->
            <div class="p-6 border-b border-white/10">
                <h1 class="text-4xl font-bold">
                    SiMukmin
                </h1>

                <p class="text-sm text-white/80 mt-1">
                    Panel Orang Tua
                </p>
            </div>

            <!-- NAVBAR -->
            <nav class="mt-8 px-4 space-y-3">

                <a href="{{ url('/orangtua') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition
                   {{ request()->is('orangtua') ? 'bg-white/20 font-semibold' : '' }}">
                    <span>🏠</span>
                    <span>Beranda</span>
                </a>

                <a href="{{ url('/orangtua/monitoring') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition
                   {{ request()->is('orangtua/monitoring*') ? 'bg-white/20 font-semibold' : '' }}">
                    <span>🕌</span>
                    <span>Monitoring Ibadah</span>
                </a>

                <a href="{{ url('/orangtua/setoran') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition
                   {{ request()->is('orangtua/setoran*') ? 'bg-white/20 font-semibold' : '' }}">
                    <span>📖</span>
                    <span>Setoran Quran</span>
                </a>

                <a href="{{ url('/orangtua/absensi') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition
                   {{ request()->is('orangtua/absensi*') ? 'bg-white/20 font-semibold' : '' }}">
                    <span>🗓️</span>
                    <span>Absensi</span>
                </a>

                <a href="{{ url('/orangtua/laporan') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition
                   {{ request()->is('orangtua.laporan*') ? 'bg-white/20 font-semibold' : '' }}">
                    <span>🏅</span>
                    <span>Prestasi & Pelanggaran</span>
                </a>

            </nav>
        </div>

        <!-- PROFILE -->
        <div class="p-4">
            <div class="bg-[#2F6F4F] rounded-2xl p-5">

                <h2 class="font-bold text-lg">
                    {{ Auth::user()->name ?? 'Orang Tua' }}
                </h2>

                <p class="text-sm text-white/70 mt-1">
                    Dashboard Orang Tua
                </p>

                @auth
                    <form method="POST" action="{{ url('/logout') }}" class="mt-4">
                        @csrf

                        <button type="submit"
                                class="w-full bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-sm transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}"
                       class="block mt-4 text-center bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-sm transition">
                        Login
                    </a>
                @endauth

            </div>
        </div>

    </aside>

    <!-- CONTENT -->
    <main class="ml-72 flex-1 p-8 h-screen overflow-y-auto">
        @yield('content')
    </main>

</div>

</body>
</html>
