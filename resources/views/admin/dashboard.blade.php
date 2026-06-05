@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex justify-between items-center">

        <div>
            <p class="text-gray-500 text-lg">
                Selamat Datang
            </p>

            <h1 class="text-4xl font-bold text-[#2F7D55] mt-2">
                Dashboard Admin
            </h1>

            <p class="text-gray-500 mt-2">
                Sistem Informasi Monitoring Siswa SDIT Mukmin
            </p>
        </div>

        <div class="bg-[#EEF7F1] px-6 py-4 rounded-2xl">
            <p class="text-sm text-gray-500">
                Hari Ini
            </p>

            <h2 class="text-xl font-bold text-[#2F7D55]">
                {{ now()->format('d M Y') }}
            </h2>
        </div>

    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <p class="text-gray-500">
                Total Siswa
            </p>

            <h2 class="text-5xl font-bold text-[#2F7D55] mt-3">
                {{ $totalSiswa }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <p class="text-gray-500">
                Total Guru
            </p>

            <h2 class="text-5xl font-bold text-blue-600 mt-3">
                {{ $totalGuru }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <p class="text-gray-500">
                Total Kelas
            </p>

            <h2 class="text-5xl font-bold text-yellow-500 mt-3">
                {{ $totalKelas }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">

            <p class="text-gray-500">
                Total Laporan
            </p>

            <h2 class="text-5xl font-bold text-red-500 mt-3">
                {{ $totalLaporan }}
            </h2>

        </div>

    </div>

    <!-- AKTIVITAS -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-[#2F7D55] mb-5">
            Aktivitas Terbaru
        </h2>

        <div class="space-y-4">

            @foreach($aktivitas as $item)

                <div class="flex items-center gap-4 border-b pb-4">

                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        📌
                    </div>

                    <div>
                        <p class="font-semibold">
                            {{ $item }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Sistem Monitoring SDIT Mukmin
                        </p>
                    </div>

                </div>

            @endforeach

        </div>

    </div>

    <!-- INFORMASI -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-[#2F7D55] mb-4">
            Informasi Sistem
        </h2>

        <p class="text-gray-600">
            Dashboard Admin digunakan untuk mengelola data siswa, guru,
            kelas, monitoring ibadah, absensi, serta laporan prestasi dan
            pelanggaran siswa.
        </p>

    </div>

</div>

@endsection