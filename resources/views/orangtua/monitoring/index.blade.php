@extends('layoutsOrtu.app')

@section('content')

@php
    $tanggalFilter = request('tanggal');

    $juzList = $monitorings->pluck('juz')->filter()->unique()->sortDesc();

    $jumlahDitampilkan = $monitorings->count();
@endphp

<div class="space-y-8">

{{-- HERO HEADER --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

    <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
    <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                MONITORING HAFALAN
            </div>

            <h1 class="text-4xl font-bold">
                Monitoring Hafalan Ananda
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                {{ $siswa->nama ?? '-' }} • Kelas {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
            </p>
        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Hari Ini
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ now()->translatedFormat('d M Y') }}
            </h2>

            <p class="text-white/80 text-sm mt-1">
                Monitoring Setoran Quran
            </p>

            <p class="text-white/60 text-xs mt-1">
                Riwayat hafalan ananda
            </p>
        </div>

    </div>

</div>

    {{-- INFO SISWA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div class="flex items-center gap-4">

                <div class="w-16 h-16 rounded-3xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Data Anak
                    </p>

                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        {{ $siswa->nama ?? '-' }}
                    </h2>

                    <p class="text-sm text-[#2F7D55] mt-1 font-semibold">
                        NIS {{ $siswa->nis ?? '-' }} • Kelas {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:min-w-[360px]">

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">
                        Total Setoran
                    </p>

                    <h3 class="text-3xl font-bold text-[#2F7D55] mt-2">
                        {{ $totalSetoran ?? 0 }}
                    </h3>
                </div>

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">
                        Rata-rata Nilai
                    </p>

                    <h3 class="text-3xl font-bold text-[#2F7D55] mt-2">
                        {{ number_format($rataNilai ?? 0, 0) }}
                    </h3>
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
                        Total Setoran
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalSetoran ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Semua jenis setoran
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold">
                    T
                </div>

            </div>

        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Tahfidz
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalTahfidz ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Hafalan Quran
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold">
                    H
                </div>

            </div>

        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Tilawah
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-3">
                        {{ $totalTilawah ?? 0 }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Bacaan Quran
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    T
                </div>

            </div>

        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Rata-rata Nilai
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-600 mt-3">
                        {{ number_format($rataNilai ?? 0, 0) }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        Nilai setoran
                    </p>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold">
                    N
                </div>

            </div>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Setoran
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih tanggal untuk melihat setoran Quran pada hari tertentu.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('orangtua.monitoring') }}"
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
                    <a href="{{ route('orangtua.monitoring') }}"
                       class="w-full text-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold transition">
                        Reset
                    </a>
                </div>

            </form>

        </div>

        @if($tanggalFilter)
            <div class="mt-6 bg-[#F6FAF8] border border-[#E6F4EC] rounded-2xl px-5 py-4">
                <p class="text-sm text-[#2F7D55] font-semibold">
                    Menampilkan setoran tanggal
                    {{ \Carbon\Carbon::parse($tanggalFilter)->format('d M Y') }}
                </p>
            </div>
        @endif

    </div>

    {{-- RIWAYAT SETORAN --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Riwayat Setoran Quran
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Daftar setoran Quran yang sudah diinput oleh guru.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $jumlahDitampilkan }} Data
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Jenis</th>
                        <th class="px-6 py-4 text-left font-semibold">Surah</th>
                        <th class="px-6 py-4 text-left font-semibold">Juz</th>
                        <th class="px-6 py-4 text-left font-semibold">Nilai</th>
                        <th class="px-6 py-4 text-left font-semibold">Catatan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($monitorings as $item)

                        @php
                            $jenis = strtolower($item->jenis ?? '');

                            $jenisClass = 'bg-gray-100 text-gray-700 border-gray-200';

                            if ($jenis == 'tahfidz') {
                                $jenisClass = 'bg-green-50 text-green-700 border-green-100';
                            } elseif ($jenis == 'tilawah') {
                                $jenisClass = 'bg-blue-50 text-blue-700 border-blue-100';
                            } elseif ($jenis == 'murajaah') {
                                $jenisClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                            }

                            $tanggalSetoran = $item->tanggal ?? $item->created_at;
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition">

                            <td class="px-6 py-5 font-semibold text-[#1F252D] whitespace-nowrap">
                                {{ $tanggalSetoran ? \Carbon\Carbon::parse($tanggalSetoran)->format('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex min-w-[95px] items-center justify-center px-4 py-2 rounded-2xl border text-sm font-semibold {{ $jenisClass }}">
                                    {{ ucfirst($item->jenis ?? '-') }}
                                </span>
                            </td>

                            <td class="px-6 py-5 font-semibold text-gray-800">
                                {{ $item->surah ?? '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-700 whitespace-nowrap">
                                {{ $item->juz ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] border border-[#DDF3E7] px-4 py-2 rounded-2xl text-sm font-bold">
                                    {{ $item->nilai ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-gray-600 min-w-[220px]">
                                {{ $item->keterangan ?? '-' }}
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
                                        Belum ada riwayat setoran
                                    </h3>

                                    <p class="text-gray-500 mt-2">
                                        Setoran Quran akan muncul setelah diinput oleh guru.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PROGRESS HAFALAN --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Progress Hafalan
                </h2>

                <p class="text-gray-500 mt-1">
                    Ringkasan juz yang sudah pernah disetorkan.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $juzList->count() }} Juz
            </div>

        </div>

        @if($juzList->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-5">

                @foreach ($juzList as $juz)

                    <div class="bg-[#F6FAF8] border border-[#E6F4EC] rounded-[1.5rem] p-5 hover:bg-white hover:shadow-sm transition">

                        <div class="flex items-center justify-between gap-4">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Juz
                                </p>

                                <h3 class="text-3xl font-bold text-[#2F7D55] mt-1">
                                    {{ $juz }}
                                </h3>
                            </div>

                            <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold">
                                J
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-[1.75rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">

                <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                    0
                </div>

                <h3 class="text-xl font-bold text-gray-700">
                    Belum ada progress hafalan
                </h3>

                <p class="text-gray-500 mt-2">
                    Progress juz akan muncul setelah ada data setoran.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
