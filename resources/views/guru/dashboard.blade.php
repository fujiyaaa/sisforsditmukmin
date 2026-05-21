@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

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
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
            <p class="text-gray-500 text-sm">
                Total Siswa
            </p>

            <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                {{ $totalSiswa ?? 0 }}
            </h2>

            <p class="text-gray-400 mt-2 text-sm">
                Data siswa aktif
            </p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
            <p class="text-gray-500 text-sm">
                Total Monitoring
            </p>

            <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                {{ $totalMonitoring ?? 0 }}
            </h2>

            <p class="text-gray-400 mt-2 text-sm">
                Monitoring ibadah siswa
            </p>
        </div>

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

        <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
            <p class="text-gray-500 text-sm">
                Setoran Quran
            </p>

            <h2 class="text-5xl font-bold text-[#2F7D55] mt-4">
                {{ $totalSetoran ?? 0 }}
            </h2>

            <p class="text-gray-400 mt-2 text-sm">
                Total setoran Quran
            </p>
        </div>

    </div>

    <!-- MENU CEPAT -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <a href="{{ url('/guru/monitoring-sholat') }}"
           class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-4">🕌</div>

            <h3 class="text-xl font-bold text-[#1F252D]">
                Monitoring Ibadah
            </h3>

            <p class="text-gray-500 mt-2 text-sm">
                Input dan lihat monitoring sholat siswa.
            </p>
        </a>

        <a href="{{ url('/guru/setoran') }}"
           class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-4">📖</div>

            <h3 class="text-xl font-bold text-[#1F252D]">
                Setoran Quran
            </h3>

            <p class="text-gray-500 mt-2 text-sm">
                Input dan lihat riwayat setoran Quran siswa.
            </p>
        </a>

        <a href="{{ url('/guru/rekap-absensi') }}"
           class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-4">🗓️</div>

            <h3 class="text-xl font-bold text-[#1F252D]">
                Rekap Absensi
            </h3>

            <p class="text-gray-500 mt-2 text-sm">
                Lihat rekap kehadiran siswa.
            </p>
        </a>

        <a href="{{ url('/guru/laporan-prestasi-pelanggaran') }}"
           class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="text-4xl mb-4">🏅</div>

            <h3 class="text-xl font-bold text-[#1F252D]">
                Prestasi & Pelanggaran
            </h3>

            <p class="text-gray-500 mt-2 text-sm">
                Kelola laporan prestasi dan pelanggaran siswa.
            </p>
        </a>

    </div>

    <!-- AKTIVITAS -->
    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Aktivitas Terbaru
            </h2>
        </div>

        <div class="space-y-4">

            @forelse($aktivitas ?? [] as $item)

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

</div>

@endsection
