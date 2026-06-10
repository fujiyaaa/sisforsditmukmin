@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-8">

    {{-- HERO HEADER --}}
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F6B4A] via-[#2F7D55] to-[#4D9A72] p-8 shadow-sm">

        <div class="absolute -right-20 -top-20 w-72 h-72 rounded-full bg-white/10"></div>
        <div class="absolute -left-16 -bottom-20 w-52 h-52 rounded-full bg-white/10"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <p class="inline-flex items-center bg-white/15 text-white text-xs tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-5">
                    LAPORAN SISWA
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    Prestasi & Pelanggaran Ananda
                </h1>

                @if ($siswa)
                    <p class="text-white/90 mt-3 max-w-2xl">
                        {{ $siswa->nama ?? '-' }} • Kelas {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
                    </p>
                @else
                    <p class="text-white/90 mt-3 max-w-2xl">
                        Data siswa belum tersedia.
                    </p>
                @endif
            </div>

            <div class="bg-white/15 backdrop-blur-sm border border-white/10 rounded-[1.5rem] px-6 py-4 text-white">
                <p class="text-xs text-white/70">
                    Hari Ini
                </p>

                <h2 class="text-xl font-bold mt-1">
                    {{ now()->format('d M Y') }}
                </h2>
            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Total Laporan
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalSemua ?? 0 }}
                    </h2>

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
                        Prestasi
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-600 mt-3">
                        {{ $totalPrestasi ?? 0 }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold">
                    P
                </div>

            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Pelanggaran
                    </p>

                    <h2 class="text-4xl font-bold text-red-600 mt-3">
                        {{ $totalPelanggaran ?? 0 }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                    P
                </div>

            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Informasi
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-3">
                        {{ $totalInformasi ?? 0 }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    I
                </div>

            </div>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Laporan
                </h2>

            </div>

            <div class="flex flex-wrap gap-3">

                <a href="{{ url('/orangtua/laporan') }}"
                   class="px-5 py-3 rounded-2xl text-sm font-semibold transition
                   {{ request('jenis') == null ? 'bg-[#2F7D55] text-white shadow-sm' : 'bg-[#F6FAF8] text-gray-600 hover:bg-[#EEF7F1] hover:text-[#2F7D55]' }}">
                    Semua
                    <span class="ml-1">
                        {{ $totalSemua ?? 0 }}
                    </span>
                </a>

                <a href="{{ url('/orangtua/laporan?jenis=prestasi') }}"
                   class="px-5 py-3 rounded-2xl text-sm font-semibold transition
                   {{ request('jenis') == 'prestasi' ? 'bg-yellow-500 text-white shadow-sm' : 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' }}">
                    Prestasi
                    <span class="ml-1">
                        {{ $totalPrestasi ?? 0 }}
                    </span>
                </a>

                <a href="{{ url('/orangtua/laporan?jenis=pelanggaran') }}"
                   class="px-5 py-3 rounded-2xl text-sm font-semibold transition
                   {{ request('jenis') == 'pelanggaran' ? 'bg-red-500 text-white shadow-sm' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                    Pelanggaran
                    <span class="ml-1">
                        {{ $totalPelanggaran ?? 0 }}
                    </span>
                </a>

                <a href="{{ url('/orangtua/laporan?jenis=informasi') }}"
                   class="px-5 py-3 rounded-2xl text-sm font-semibold transition
                   {{ request('jenis') == 'informasi' ? 'bg-blue-500 text-white shadow-sm' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                    Informasi
                    <span class="ml-1">
                        {{ $totalInformasi ?? 0 }}
                    </span>
                </a>

            </div>

        </div>

    </div>

    {{-- RIWAYAT LAPORAN --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    @if (request('jenis') == 'prestasi')
                        Riwayat Prestasi
                    @elseif (request('jenis') == 'pelanggaran')
                        Riwayat Pelanggaran
                    @elseif (request('jenis') == 'informasi')
                        Riwayat Informasi
                    @else
                        Riwayat Laporan
                    @endif
                </h2>

            </div>



        </div>

        @if($laporans->count() > 0)

            <div class="grid grid-cols-1 gap-5">

                @foreach ($laporans as $laporan)

                    @php
                        $jenisClass = 'bg-blue-50 text-blue-700 border-blue-100';
                        $jenisLabel = 'Informasi';
                        $kodeJenis = 'I';

                        if ($laporan->jenis == 'prestasi') {
                            $jenisClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                            $jenisLabel = 'Prestasi';
                            $kodeJenis = 'P';
                        } elseif ($laporan->jenis == 'pelanggaran') {
                            $jenisClass = 'bg-red-50 text-red-700 border-red-100';
                            $jenisLabel = 'Pelanggaran';
                            $kodeJenis = 'P';
                        }
                    @endphp

                    <div class="group border border-gray-100 rounded-[1.75rem] p-6 bg-[#FAFCFB] hover:bg-white hover:shadow-sm hover:border-[#DDF3E7] transition">

                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

                            <div class="flex items-start gap-4">

                                <div class="w-12 h-12 rounded-2xl {{ $jenisClass }} border flex items-center justify-center font-bold shrink-0">
                                    {{ $kodeJenis }}
                                </div>

                                <div>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border {{ $jenisClass }}">
                                        {{ $jenisLabel }}
                                    </span>

                                    <h3 class="text-xl font-bold text-[#1F252D] mt-4">
                                        {{ $laporan->judul }}
                                    </h3>

                                    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mt-2">

                                        <span>
                                            {{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : '-' }}
                                        </span>

                                        @if ($laporan->tingkat)
                                            <span>•</span>
                                            <span>{{ $laporan->tingkat }}</span>
                                        @endif

                                    </div>
                                </div>

                            </div>

                            <div class="text-sm text-gray-400 lg:text-right">
                                <p>Dibuat</p>

                                <p class="font-semibold text-gray-600 mt-1">
                                    {{ $laporan->created_at ? $laporan->created_at->format('d M Y') : '-' }}
                                </p>
                            </div>

                        </div>

                        @if($laporan->deskripsi)
                            <div class="mt-6 bg-white rounded-2xl p-5 border border-gray-100">
                                <p class="text-sm font-semibold text-gray-500 mb-2">
                                    Deskripsi
                                </p>

                                <p class="text-gray-700 leading-relaxed">
                                    {{ $laporan->deskripsi }}
                                </p>
                            </div>
                        @endif

                        {{-- LAMPIRAN PRESTASI --}}
                        @if ($laporan->jenis == 'prestasi' && !empty($laporan->sertifikat))

                            @php
                                $fileUrl = asset('storage/' . $laporan->sertifikat);
                                $extension = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                            @endphp

                            <div class="mt-5 bg-white rounded-2xl p-5 border border-gray-100">

                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">
                                            Lampiran Prestasi
                                        </p>

                                        <p class="text-xs text-gray-400 mt-1">
                                            File pendukung laporan prestasi.
                                        </p>
                                    </div>

                                    <a href="{{ $fileUrl }}"
                                       target="_blank"
                                       class="inline-flex items-center justify-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold transition">
                                        Buka Lampiran
                                    </a>
                                </div>

                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))

                                    <a href="{{ $fileUrl }}" target="_blank">
                                        <img src="{{ $fileUrl }}"
                                             alt="Lampiran Prestasi"
                                             class="w-full max-h-[420px] object-contain rounded-2xl border border-gray-100 bg-gray-50">
                                    </a>

                                @elseif ($extension == 'pdf')

                                    <a href="{{ $fileUrl }}"
                                       target="_blank"
                                       class="inline-flex items-center justify-center bg-yellow-50 text-yellow-700 px-5 py-3 rounded-2xl font-semibold hover:bg-yellow-100 transition">
                                        Lihat Lampiran PDF
                                    </a>

                                @else

                                    <a href="{{ $fileUrl }}"
                                       target="_blank"
                                       class="inline-flex items-center justify-center bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl font-semibold hover:bg-gray-200 transition">
                                        Unduh Lampiran
                                    </a>

                                @endif

                            </div>

                        @endif

                        @if ($laporan->catatan)
                            <div class="mt-5 bg-[#F6FAF8] rounded-2xl p-5 border border-[#E6F4EC]">

                                <p class="text-sm font-semibold text-[#2F7D55] mb-2">
                                    Catatan Guru/Admin
                                </p>

                                <p class="text-gray-700 leading-relaxed">
                                    {{ $laporan->catatan }}
                                </p>

                            </div>
                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-[1.75rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">

                <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                    0
                </div>

                <h3 class="text-xl font-bold text-gray-700">
                    Belum ada laporan
                </h3>

                <p class="text-gray-500 mt-2">
                    Laporan prestasi, pelanggaran, atau informasi siswa akan muncul di sini.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
