@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-8">

    {{-- HERO HEADER --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    BERANDA
                </div>

                <h1 class="text-4xl font-bold">
                    Dashboard Orang Tua
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">

                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">

                </p>

                <h2 class="text-2xl font-bold mt-1">
                    Akun aktif
                </h2>


            </div>

        </div>

    </div>

{{-- BIODATA ANAK --}}
<div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Biodata Siswa
            </h2>

            <p class="text-gray-500 mt-1">
                Data siswa yang terhubung
            </p>
        </div>

    </div>

    @if($siswas->count() > 0)

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            @foreach($siswas as $siswa)

                <div class="rounded-3xl border border-gray-100 bg-[#F8FBF9] p-5 hover:bg-white hover:shadow-md transition">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                        {{-- IDENTITAS --}}
                        <div class="flex items-center gap-4 min-w-0">

                            <div class="w-14 h-14 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-xl shrink-0">
                                {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-xl font-bold text-[#1F252D] truncate">
                                    {{ $siswa->nama ?? '-' }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Siswa Aktif
                                </p>
                            </div>

                        </div>

                        {{-- INFO --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full lg:w-auto">

                            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 min-w-[130px]">
                                <p class="text-xs text-gray-500 mb-1">
                                    NIS
                                </p>

                                <p class="font-bold text-[#1F252D] truncate">
                                    {{ $siswa->nis ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 min-w-[110px]">
                                <p class="text-xs text-gray-500 mb-1">
                                    Kelas
                                </p>

                                <p class="font-bold text-[#1F252D]">
                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 min-w-[130px]">
                                <p class="text-xs text-gray-500 mb-1">
                                    Status
                                </p>

                                <span class="inline-flex items-center px-3 py-1 rounded-xl bg-[#EEF7F1] text-[#2F7D55] text-sm font-semibold">
                                    Terhubung
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="text-center py-14 bg-[#F8FBF9] rounded-3xl border border-dashed border-gray-200">

            <div class="w-16 h-16 mx-auto rounded-full bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                0
            </div>

            <h3 class="text-xl font-bold text-[#1F252D]">
                Belum Ada Anak Terhubung
            </h3>

            <p class="text-gray-500 mt-2">
                Hubungi admin untuk menghubungkan akun orang tua dengan data siswa.
            </p>

        </div>

    @endif

</div>

    {{-- RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-full translate-x-8 -translate-y-8"></div>

            <div class="relative">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold mb-5">
                    Q
                </div>

                <p class="text-gray-500">
                    Total Setoran Quran
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    {{ $totalSetoran ?? 0 }}
                </h2>

                <p class="text-sm text-emerald-600 mt-2 font-semibold">
                    Tahfidz, Murajaah, Tilawah
                </p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-full translate-x-8 -translate-y-8"></div>

            <div class="relative">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold mb-5">
                    S
                </div>

                <p class="text-gray-500">
                    Total Checklist Sholat
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    {{ $totalSholat ?? 0 }}
                </h2>

                <p class="text-sm text-blue-600 mt-2 font-semibold">
                    Sholat Fardhu
                </p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-full translate-x-8 -translate-y-8"></div>

            <div class="relative">
                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-700 flex items-center justify-center font-bold mb-5">
                    A
                </div>

                <p class="text-gray-500">
                    Absensi Bulan  {{ now()->translatedFormat(' M Y ') }}
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    {{ $persentaseAbsensi ?? 0 }}%
                </h2>

                <p class="text-sm text-yellow-600 mt-2 font-semibold">
                    Presensi
                </p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-full translate-x-8 -translate-y-8"></div>

            <div class="relative">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-700 flex items-center justify-center font-bold mb-5">
                    L
                </div>

                <p class="text-gray-500">
                    Total Laporan
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    {{ $totalLaporan ?? 0 }}
                </h2>

                <p class="text-sm text-red-600 mt-2 font-semibold">
                    Prestasi, pelanggaran, informasi
                </p>
            </div>
        </div>

    </div>

    {{-- SETORAN DAN REKAP LAPORAN --}}
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        {{-- SETORAN TERBARU --}}
        <div class="xl:col-span-8 bg-white rounded-3xl shadow-md p-8 border border-gray-100">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                <div>
                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Setoran Quran Terbaru
                    </h2>

                    <p class="text-gray-500 mt-1">

                    </p>
                </div>

                <a href="{{ url('/orangtua/monitoring') }}"
                   class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold hover:bg-[#DDF3E7] transition">
                    Lihat Detail
                </a>

            </div>

            <div class="space-y-4">

                @forelse($setoranTerbaru as $item)

                    @php
                        $jenis = strtolower($item->jenis ?? '');

                        $jenisClass = 'bg-gray-100 text-gray-700 border-gray-200';
                        $jenisIcon = 'Q';

                        if ($jenis === 'tahfidz') {
                            $jenisClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            $jenisIcon = 'T';
                        } elseif ($jenis === 'murajaah') {
                            $jenisClass = 'bg-blue-50 text-blue-700 border-blue-200';
                            $jenisIcon = 'M';
                        } elseif ($jenis === 'tilawah') {
                            $jenisClass = 'bg-purple-50 text-purple-700 border-purple-200';
                            $jenisIcon = 'L';
                        }
                    @endphp

                    <div class="group rounded-3xl border border-gray-100 bg-[#F8FBF9] hover:bg-white hover:shadow-md transition p-5">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-2xl border flex items-center justify-center font-bold text-xl {{ $jenisClass }}">
                                    {{ $jenisIcon }}
                                </div>

                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-2">

                                        <span class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $jenisClass }}">
                                            {{ ucfirst($item->jenis ?? '-') }}
                                        </span>

                                        <span class="text-sm text-gray-400">
                                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                                        </span>

                                    </div>

                                    <h3 class="text-lg font-bold text-[#1F252D]">
                                        {{ $item->surah ?? '-' }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $item->siswa->nama ?? '-' }} · Juz {{ $item->juz ?? '-' }}
                                    </p>
                                </div>

                            </div>

                            <div class="flex md:flex-col items-center md:items-end gap-2">

                                <p class="text-sm text-gray-400">
                                    Nilai
                                </p>

                                <div class="min-w-[70px] text-center bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                                    <span class="text-2xl font-bold text-[#2F7D55]">
                                        {{ $item->nilai ?? '-' }}
                                    </span>
                                </div>

                            </div>

                        </div>

                        @if(!empty($item->keterangan))
                            <div class="mt-4 bg-white border border-gray-100 rounded-2xl px-4 py-3 text-sm text-gray-500">
                                {{ $item->keterangan }}
                            </div>
                        @endif

                    </div>

                @empty

                    <div class="text-center py-14 bg-[#F8FBF9] rounded-3xl border border-dashed border-gray-200">

                        <div class="w-16 h-16 mx-auto rounded-full bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                            0
                        </div>

                        <h3 class="text-xl font-bold text-[#1F252D]">
                            Belum Ada Setoran
                        </h3>

                        <p class="text-gray-500 mt-2">
                            Data setoran Quran akan tampil setelah guru atau admin menginput setoran.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

        {{-- REKAP LAPORAN COMPACT --}}
        <div class="xl:col-span-4 bg-white rounded-3xl shadow-md p-6 border border-gray-100">

            <div class="mb-5">
                <h2 class="text-xl font-bold text-[#1F252D]">
                    Rekap Laporan
                </h2>

            </div>

            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-5 text-white mb-5">

                <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-full translate-x-8 -translate-y-8"></div>

                <div class="relative">
                    <p class="text-sm text-white/70">
                        Total Laporan
                    </p>

                    <h2 class="text-4xl font-bold mt-1">
                        {{ $totalLaporan ?? 0 }}
                    </h2>

                    <p class="text-sm text-white/70 mt-1">
                        Semua laporan ananda
                    </p>
                </div>

            </div>

            <div class="space-y-3">

                <div class="flex items-center justify-between rounded-2xl bg-yellow-50 border border-yellow-100 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold">
                            P
                        </div>

                        <span class="font-semibold text-yellow-700">
                            Prestasi
                        </span>
                    </div>

                    <span class="text-xl font-bold text-yellow-700">
                        {{ $totalPrestasi ?? 0 }}
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-2xl bg-red-50 border border-red-100 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-red-100 text-red-700 flex items-center justify-center font-bold">
                            !
                        </div>

                        <span class="font-semibold text-red-700">
                            Pelanggaran
                        </span>
                    </div>

                    <span class="text-xl font-bold text-red-700">
                        {{ $totalPelanggaran ?? 0 }}
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-2xl bg-blue-50 border border-blue-100 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            I
                        </div>

                        <span class="font-semibold text-blue-700">
                            Informasi
                        </span>
                    </div>

                    <span class="text-xl font-bold text-blue-700">
                        {{ $totalInformasi ?? 0 }}
                    </span>
                </div>

            </div>

            <a href="{{ url('/orangtua/laporan') }}"
               class="mt-5 w-full inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold hover:bg-[#DDF3E7] transition">
                Lihat Laporan
            </a>

        </div>

    </div>

</div>

@endsection
