@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h1 class="text-4xl font-bold text-[#2e8b57]">
            Dashboard
        </h1>

        <p class="text-gray-500 mt-2">
            Selamat datang di Sistem Informasi Monitoring Siswa SDIT Mukmin.
        </p>

    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-gray-500">
                Total Monitoring
            </p>

            <h2 class="text-4xl font-bold text-[#2e8b57] mt-3">
                12
            </h2>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-gray-500">
                Absensi Bulan Ini
            </p>

            <h2 class="text-4xl font-bold text-[#2e8b57] mt-3">
                98%
            </h2>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-gray-500">
                Prestasi Anak
            </p>

            <h2 class="text-4xl font-bold text-[#2e8b57] mt-3">
                5
            </h2>
        </div>

    </div>

    <!-- INFORMASI -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h3 class="text-2xl font-bold text-[#2e8b57] mb-4">
            Informasi
        </h3>

        <p class="text-gray-600">
            Gunakan menu di sebelah kiri untuk melihat monitoring,
            ibadah sholat, serta laporan prestasi dan pelanggaran siswa.
        </p>

    </div>

</div>

@endsection