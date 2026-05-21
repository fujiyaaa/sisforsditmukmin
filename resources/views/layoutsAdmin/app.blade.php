<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SiMukmin Admin</title>

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
                    Panel Admin
                </p>

            </div>

            <!-- NAVBAR -->
            <nav class="mt-8 px-4 space-y-3">

                <a href="/dashboard-admin"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>

                <a href="/admin/siswa"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">
                    <span>👨‍🎓</span>
                    <span>Kelola Siswa</span>
                </a>

                <a href="/admin/kelas"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">
                    <span>🏫</span>
                    <span>Kelola Kelas</span>
                </a>

                <a href="/admin/guru"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">
                    <span>👨‍🏫</span>
                    <span>Kelola Guru</span>
                </a>

                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition
                    {{ request()->is('admin/laporan-prestasi-pelanggaran*') ? 'bg-white/20 font-semibold' : '' }}">
                        <span>🏅</span>
                        <span>Laporan Prestasi & Pelanggaran</span>
                </a>

            </nav>

        </div>

        <!-- PROFILE -->
        <div class="p-4">

            <div class="bg-[#2F6F4F] rounded-2xl p-5">

                <h2 class="font-bold text-lg">
                    {{ Auth::user()->name ?? 'Admin' }}
                </h2>

                <p class="text-sm text-white/70 mt-1">
                    Dashboard Admin
                </p>

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
