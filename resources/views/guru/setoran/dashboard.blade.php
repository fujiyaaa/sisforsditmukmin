<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Dashboard Guru</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F3F3F3] font-sans">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-[#4D9A72] text-white flex flex-col justify-between shadow-2xl">

        <div>

            <!-- LOGO -->
            <div class="p-6 border-b border-white/10">

                <h1 class="text-4xl font-bold">
                    SiMukmin
                </h1>

                <p class="text-sm text-white/80 mt-1">
                    Panel Guru
                </p>

            </div>

            <!-- NAVBAR -->
             <nav class="mt-8 px-4 space-y-3">

                <a href="/dashboard-guru"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>🏠</span>
                    <span>Dashboard</span>

                </a>

                <a href="/guru/monitoring"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>🕌</span>
                    <span>Monitoring</span>

                </a>

                <a href="/guru/absensi"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>📋</span>
                    <span>Absensi</span>

                </a>

                <a href="/guru/hafalan"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>📖</span>
                    <span>Hafalan Qur'an</span>

                </a>

            </nav>
        </div>

        <!-- PROFILE -->
        <div class="p-4">

            <div class="bg-[#2F6F4F] rounded-2xl p-5 hover:bg-[#276347] transition">

                <h2 class="font-bold text-lg">
                    {{ Auth::user()->name ?? 'Guru' }}
                </h2>

                <p class="text-sm text-white/70 mt-1">
                    Dashboard Guru
                </p>

            </div>

        </div>

    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100 flex items-center justify-between">

            <div>

                <h1 class="text-4xl font-bold text-[#1F252D]">
                    Dashboard Guru
                </h1>

                <p class="text-gray-500 mt-2 text-lg">
                    Monitoring aktivitas siswa dan ibadah
                </p>

            </div>

            <div class="bg-[#EEF7F1] px-6 py-4 rounded-2xl">

                <p class="text-sm text-gray-500">
                    Hari Ini
                </p>

                <h2 class="text-xl font-bold text-[#2F7D55] mt-1">
                    {{ now()->format('d M Y') }}
                </h2>

            </div>

        </div>

        <!-- STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-8">

            <!-- Total Siswa -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">

                <p class="text-gray-500 text-sm">
                    Total Siswa
                </p>

                <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                    {{ $totalSiswa }}
                </h2>

                <p class="text-gray-400 mt-2 text-sm">
                    Data siswa aktif
                </p>

            </div>

            <!-- Monitoring -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">

                <p class="text-gray-500 text-sm">
                    Total Monitoring
                </p>

                <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                    {{ $totalMonitoring }}
                </h2>

                <p class="text-gray-400 mt-2 text-sm">
                    Monitoring ibadah siswa
                </p>

            </div>

            <!-- Absensi -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">

                <p class="text-gray-500 text-sm">
                    Kehadiran
                </p>

                <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                    98%
                </h2>

                <p class="text-gray-400 mt-2 text-sm">
                    Kehadiran siswa hari ini
                </p>

            </div>

            <!-- Hafalan -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">

                <p class="text-gray-500 text-sm">
                    Hafalan Qur'an
                </p>

                <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                    30
                </h2>

                <p class="text-gray-400 mt-2 text-sm">
                    Total setoran hafalan
                </p>

            </div>

        </div>

        <!-- AKTIVITAS -->
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mt-8">

            <div class="flex items-center justify-between mb-6">

                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Aktivitas Terbaru
                </h2>

                <button class="bg-[#2F7D55] text-white px-5 py-2 rounded-xl hover:bg-[#276A48] transition">

                    Lihat Semua

                </button>

            </div>

            <div class="space-y-4">

                @forelse($aktivitas as $item)

                    <div class="bg-[#F8FBF9] border border-[#E1EEE5] rounded-2xl p-5">

                        <h3 class="font-semibold text-[#1F252D] text-lg">
                            {{ $item }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-2">
                            Aktivitas berhasil diperbarui.
                        </p>

                    </div>

                @empty

                    <div class="bg-[#F8FBF9] border border-[#E1EEE5] rounded-2xl p-5">

                        <h3 class="font-semibold text-[#1F252D] text-lg">
                            Belum ada aktivitas terbaru
                        </h3>

                    </div>

                @endforelse

            </div>

        </div>

    </main>

</div>

</body>
</html>