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
    <aside class="fixed left-0 top-0 z-40 h-screen w-72 bg-white border-r border-gray-100 shadow-sm flex flex-col justify-between">

        <div>

            <!-- LOGO -->
            <div class="px-6 py-7 border-b border-gray-100">

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-2xl bg-[#4D9A72] flex items-center justify-center text-white font-bold text-lg">
                        SM
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-[#1F252D] leading-tight">
                            SiMukmin
                        </h1>

                        <p class="text-sm text-gray-400 mt-0.5">
                            Admin Panel
                        </p>
                    </div>

                </div>

            </div>

            <!-- NAVBAR -->
            <nav class="mt-6 px-4 space-y-2">

                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Dashboard
                    </span>
                </a>

                <a href="/admin/siswa"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('admin/siswa*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('admin/siswa*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Kelola Siswa
                    </span>
                </a>

                <a href="/admin/kelas"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('admin/kelas*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('admin/kelas*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Kelola Kelas
                    </span>
                </a>

                <a href="/admin/guru"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->is('admin/guru*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->is('admin/guru*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Kelola Guru
                    </span>
                </a>

                <a href="{{ route('admin.laporan.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->routeIs('admin.laporan.*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.laporan.*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span class="leading-snug">
                        Laporan Prestasi & Pelanggaran
                    </span>
                </a>

                <a href="{{ route('admin.akun.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->routeIs('admin.akun.*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.akun.*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Kelola Akun
                    </span>
                </a>

                <a href="{{ route('admin.hak-akses-guru.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->routeIs('admin.hak-akses-guru.*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.hak-akses-guru.*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Hak Akses Guru
                    </span>
                </a>

                <a href="{{ route('admin.rekap-persentase.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition
                          {{ request()->routeIs('admin.rekap-persentase.*') ? 'bg-[#EEF7F1] text-[#2F7D55] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#2F7D55]' }}">

                    <span class="w-2 h-2 rounded-full {{ request()->routeIs('admin.rekap-persentase.*') ? 'bg-[#4D9A72]' : 'bg-gray-300 group-hover:bg-[#4D9A72]' }}"></span>

                    <span>
                        Rekap Persentase
                    </span>
                </a>

            </nav>

        </div>

        <!-- PROFILE -->
        <div class="p-4 border-t border-gray-100">

            <div class="bg-[#F8FBF9] rounded-3xl p-5 border border-gray-100">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-11 h-11 rounded-2xl bg-[#4D9A72] text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h2 class="font-bold text-[#1F252D] truncate">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </h2>

                        <p class="text-sm text-gray-400">
                            Administrator
                        </p>
                    </div>

                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full bg-white text-red-600 border border-red-100 px-5 py-3 rounded-2xl hover:bg-red-50 transition font-semibold text-left">
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
