@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HERO HEADER -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F5F43] via-[#2F7D55] to-[#75C295] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-[#DDF3E7]/20 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-8">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-xs font-bold tracking-[0.2em] mb-5">
                    PANEL ADMINISTRATOR
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Dashboard Admin
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Kelola data siswa, guru, kelas, absensi, laporan, dan rekap monitoring siswa SDIT Mukmin Kreatif.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[250px] border border-white/15">
                <p class="text-sm text-white/70">
                    Hari Ini
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ now()->format('d M Y') }}
                </h2>

                <p class="text-white/70 text-sm mt-1">
                    Sistem aktif
                </p>
            </div>

        </div>

    </div>

    <!-- STATISTIK UTAMA -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- TOTAL SISWA -->
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-gray-500">
                        Total Siswa
                    </p>

                    <h2 class="text-5xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalSiswa }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-3">
                        Data siswa terdaftar
                    </p>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-bold text-sm">
                    SISWA
                </div>

            </div>

            <div class="w-full bg-gray-100 rounded-full h-2 mt-6">
                <div class="bg-[#4D9A72] h-2 rounded-full" style="width: 100%"></div>
            </div>

        </div>

        <!-- TOTAL GURU -->
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-gray-500">
                        Total Guru
                    </p>

                    <h2 class="text-5xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalGuru }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-3">
                        Guru pengguna sistem
                    </p>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-bold text-sm">
                    GURU
                </div>

            </div>

            <div class="w-full bg-gray-100 rounded-full h-2 mt-6">
                <div class="bg-[#75C295] h-2 rounded-full" style="width: 100%"></div>
            </div>

        </div>

        <!-- TOTAL KELAS -->
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-gray-500">
                        Total Kelas
                    </p>

                    <h2 class="text-5xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalKelas }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-3">
                        Kelas aktif
                    </p>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-bold text-sm">
                    KELAS
                </div>

            </div>

            <div class="w-full bg-gray-100 rounded-full h-2 mt-6">
                <div class="bg-[#E3B341] h-2 rounded-full" style="width: 100%"></div>
            </div>

        </div>

        <!-- TOTAL LAPORAN -->
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100 hover:shadow-md transition">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-gray-500">
                        Total Laporan
                    </p>

                    <h2 class="text-5xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalLaporan }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-3">
                        Prestasi & pelanggaran
                    </p>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-bold text-sm">
                    LAPORAN
                </div>

            </div>

            <div class="w-full bg-gray-100 rounded-full h-2 mt-6">
                <div class="bg-[#D96C6C] h-2 rounded-full" style="width: 100%"></div>
            </div>

        </div>

    </div>

    <!-- AKSI CEPAT + RINGKASAN SISTEM -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- AKSI CEPAT -->
        <div class="xl:col-span-1 bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Aksi Cepat
                </h2>

                <p class="text-gray-500 mt-1">
                    Pintasan untuk fitur utama admin.
                </p>
            </div>

            <div class="space-y-3">

                <a href="/admin/siswa"
                   class="block bg-[#F8FBF9] border border-gray-100 rounded-2xl p-4 hover:bg-[#EEF7F1] transition">

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-[#1F252D]">
                                Kelola Siswa
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Tambah, edit, dan lihat data siswa.
                            </p>
                        </div>

                        <span class="text-[#2F7D55] font-bold">
                            Buka
                        </span>
                    </div>

                </a>

                <a href="/admin/guru"
                   class="block bg-[#F8FBF9] border border-gray-100 rounded-2xl p-4 hover:bg-[#EEF7F1] transition">

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-[#1F252D]">
                                Kelola Guru
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Atur data guru dan pengguna.
                            </p>
                        </div>

                        <span class="text-[#2F7D55] font-bold">
                            Buka
                        </span>
                    </div>

                </a>

                <a href="{{ route('admin.absensi.index') }}"
                   class="block bg-[#F8FBF9] border border-gray-100 rounded-2xl p-4 hover:bg-[#EEF7F1] transition">

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-[#1F252D]">
                                Absensi Siswa
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Input absensi semua kelas.
                            </p>
                        </div>

                        <span class="text-[#2F7D55] font-bold">
                            Buka
                        </span>
                    </div>

                </a>

                <a href="{{ route('admin.rekap-persentase.index') }}"
                   class="block bg-[#F8FBF9] border border-gray-100 rounded-2xl p-4 hover:bg-[#EEF7F1] transition">

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-[#1F252D]">
                                Rekap Persentase
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Lihat persentase sholat dan absensi.
                            </p>
                        </div>

                        <span class="text-[#2F7D55] font-bold">
                            Buka
                        </span>
                    </div>

                </a>

            </div>

        </div>

        <!-- RINGKASAN SISTEM -->
        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Ringkasan Sistem
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Informasi singkat mengenai fitur dan pengelolaan sistem SiMukmin.
                    </p>
                </div>

                <div class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl font-bold text-sm">
                    Panel Admin
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-gradient-to-br from-[#F8FBF9] to-white border border-gray-100 rounded-3xl p-6">
                    <div class="border-l-4 border-[#4D9A72] pl-5">
                        <h3 class="font-bold text-[#1F252D]">
                            Pengelolaan Data Utama
                        </h3>

                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Admin dapat mengelola data siswa, guru, kelas, akun pengguna, serta hak akses guru.
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#F8FBF9] to-white border border-gray-100 rounded-3xl p-6">
                    <div class="border-l-4 border-[#75C295] pl-5">
                        <h3 class="font-bold text-[#1F252D]">
                            Absensi Semua Kelas
                        </h3>

                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Admin dapat menginput dan memantau absensi siswa dari semua kelas tanpa batasan akses.
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#F8FBF9] to-white border border-gray-100 rounded-3xl p-6">
                    <div class="border-l-4 border-[#E3B341] pl-5">
                        <h3 class="font-bold text-[#1F252D]">
                            Laporan Siswa
                        </h3>

                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Laporan prestasi, pelanggaran, dan informasi siswa dapat dipantau melalui panel admin.
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#F8FBF9] to-white border border-gray-100 rounded-3xl p-6">
                    <div class="border-l-4 border-[#D96C6C] pl-5">
                        <h3 class="font-bold text-[#1F252D]">
                            Rekap Monitoring
                        </h3>

                        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                            Persentase sholat dan absensi dapat dilihat berdasarkan kelas, siswa, bulan, dan tahun ajaran.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- INFORMASI SISTEM -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

            <div class="xl:col-span-2">
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Informasi Sistem
                </h2>

                <p class="text-gray-600 mt-3 leading-relaxed">
                    Dashboard Admin digunakan untuk mengelola data siswa, guru, kelas, akun pengguna,
                    hak akses guru, absensi siswa, monitoring ibadah, serta laporan prestasi dan
                    pelanggaran siswa. Gunakan menu di sidebar atau aksi cepat untuk mengakses fitur utama.
                </p>
            </div>

            <div class="bg-gradient-to-br from-[#EEF7F1] to-[#F8FBF9] rounded-3xl p-6 border border-[#DDF3E7]">

                <p class="text-sm text-gray-500">
                    Status Sistem
                </p>

                <h3 class="text-2xl font-bold text-[#2F7D55] mt-2">
                    Berjalan Normal
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Data ditampilkan berdasarkan database sistem SiMukmin.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection
