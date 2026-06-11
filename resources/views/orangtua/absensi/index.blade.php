@extends('layoutsOrtu.app')

@section('content')

@php
    $persen = $persentaseHadir ?? 0;
@endphp

<div class="space-y-8">

 {{-- HERO HEADER --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

    <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
    <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                REKAP ABSENSI
            </div>

            <h1 class="text-4xl font-bold">
                Rekapitulasi Absensi
            </h1>

        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Persentase Kehadiran
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ $persentaseKehadiran ?? 0 }}%
            </h2>

            <p class="text-white/80 text-sm mt-1">
                Rekap Absensi Siswa
            </p>

            <p class="text-white/60 text-xs mt-1">
                Riwayat kehadiran ananda
            </p>
        </div>

    </div>

</div>

    {{-- PROFIL SISWA + PROGRESS --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

        <div class="xl:col-span-3 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <div class="flex items-center gap-4">

                    <div class="w-16 h-16 rounded-3xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Data Siswa
                        </p>

                        <h2 class="text-2xl font-bold text-[#1F252D]">
                            {{ $siswa->nama ?? '-' }}
                        </h2>

                        <p class="text-sm text-[#2F7D55] mt-1 font-semibold">
                            NIS {{ $siswa->nis ?? '-' }} • Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </p>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-4 md:min-w-[260px]">

                    <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5 text-center">
                        <h3 class="text-3xl font-bold text-[#2F7D55]">
                            {{ $persentaseHadir ?? 0 }}%
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Kehadiran
                        </p>
                    </div>

                    <div class="rounded-3xl bg-yellow-50 border border-yellow-100 p-5 text-center">
                        <h3 class="text-3xl font-bold text-yellow-600">
                            {{ $totalTerlambat ?? 0 }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Terlambat
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

            <p class="text-sm text-gray-500">
                Progress Kehadiran
            </p>

            <div class="mt-4 flex items-end gap-2">
                <h2 class="text-5xl font-bold text-[#2F7D55]">
                    {{ $persen }}
                </h2>

                <span class="text-gray-400 font-semibold mb-2">
                    %
                </span>
            </div>

            <div class="mt-5 w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#2F7D55] rounded-full transition-all"
                     style="width: {{ $persen }}%">
                </div>
            </div>


        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Hadir
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-3">
                        {{ $totalHadir ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Total kehadiran
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center font-bold">
                    H
                </div>

            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Izin
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-600 mt-3">
                        {{ $totalIzin ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Total izin
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold">
                    I
                </div>

            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Sakit
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-3">
                        {{ $totalSakit ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Total sakit
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    S
                </div>

            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Alpha
                    </p>

                    <h2 class="text-4xl font-bold text-red-600 mt-3">
                        {{ $totalAlpha ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Tanpa keterangan
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                    A
                </div>

            </div>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Absensi
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih tanggal untuk melihat absensi pada hari tertentu.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('orangtua.absensi') }}"
                  class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full lg:max-w-3xl">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pilih Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ request('tanggal') }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-4 rounded-2xl font-semibold transition shadow-sm">
                        Filter
                    </button>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('orangtua.absensi') }}"
                       class="w-full text-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold transition">
                        Reset
                    </a>
                </div>

            </form>

        </div>

    </div>

    {{-- RIWAYAT ABSENSI --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                   Daftar Absensi
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Daftar absensi ananda yang telah diinput oleh guru.
                </p>

                @if (request('tanggal'))
                    <p class="text-sm text-[#2F7D55] font-semibold mt-2">
                        Menampilkan absensi tanggal
                        {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}
                    </p>
                @endif
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $absensis->count() ?? 0 }} Data
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px]">

                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Hari</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu Masuk</th>
                        <th class="px-6 py-4 text-left font-semibold">Keterlambatan</th>
                        <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($absensis as $absensi)

                        @php
                            $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
                            $statusLabel = ucfirst($absensi->status ?? '-');

                            if ($absensi->status == 'hadir') {
                                $statusClass = 'bg-green-50 text-green-700 border-green-100';
                                $statusLabel = 'Hadir';
                            } elseif ($absensi->status == 'izin') {
                                $statusClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                $statusLabel = 'Izin';
                            } elseif ($absensi->status == 'sakit') {
                                $statusClass = 'bg-blue-50 text-blue-700 border-blue-100';
                                $statusLabel = 'Sakit';
                            } elseif ($absensi->status == 'alpha') {
                                $statusClass = 'bg-red-50 text-red-700 border-red-100';
                                $statusLabel = 'Alpha';
                            }
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition">

                            <td class="px-6 py-5 font-semibold text-[#1F252D] whitespace-nowrap">
                                {{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-600 whitespace-nowrap">
                                {{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l') : '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex min-w-[90px] items-center justify-center px-4 py-2 rounded-2xl border text-sm font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-5 font-semibold text-gray-700 whitespace-nowrap">
                                {{ $absensi->waktu_absen ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">

                                @if ($absensi->keterlambatan && $absensi->keterlambatan > 0)
                                    <span class="inline-flex items-center justify-center bg-yellow-50 text-yellow-700 border border-yellow-100 px-4 py-2 rounded-2xl text-sm font-semibold">
                                        {{ $absensi->keterlambatan }} menit
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] border border-[#DDF3E7] px-4 py-2 rounded-2xl text-sm font-semibold">
                                        Tepat Waktu
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-5 text-gray-600 min-w-[220px]">
                                {{ $absensi->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="py-14">
                                <div class="text-center">

                                    <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                                        0
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-700">
                                        Belum ada data absensi
                                    </h3>

                                    <p class="text-gray-500 mt-2">
                                        Data absensi siswa akan muncul setelah diinput oleh guru.
                                    </p>

                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
