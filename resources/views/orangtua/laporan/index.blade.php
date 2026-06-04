@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <p class="text-gray-500 text-lg">
                Assalamu'alaikum, Bapak/Ibu Orang Tua
            </p>

            <h1 class="text-3xl font-bold text-[#1F6B4A] mt-2">
                Laporan Prestasi & Pelanggaran Ananda
            </h1>

            @if ($siswa)
                <p class="text-gray-500 mt-2">
                    {{ $siswa->nama ?? '-' }} | Kelas {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
                </p>
            @else
                <p class="text-gray-500 mt-2">
                    Data siswa belum tersedia.
                </p>
            @endif
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Total Laporan
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalSemua ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    📄
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Prestasi
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-600 mt-3">
                        {{ $totalPrestasi ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    🏆
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Pelanggaran
                    </p>

                    <h2 class="text-4xl font-bold text-red-600 mt-3">
                        {{ $totalPelanggaran ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    ⚠️
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Informasi
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-3">
                        {{ $totalInformasi ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    ℹ️
                </div>
            </div>
        </div>

    </div>

    <!-- FILTER INFO -->
    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">

        <div class="flex flex-wrap gap-3">

            <a href="{{ url('/orangtua/laporan') }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition
               {{ request('jenis') == null ? 'bg-[#4D9A72] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua
                <span class="ml-1">
                    {{ $totalSemua ?? 0 }}
                </span>
            </a>

            <a href="{{ url('/orangtua/laporan?jenis=prestasi') }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition
               {{ request('jenis') == 'prestasi' ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                🏆 Prestasi
                <span class="ml-1">
                    {{ $totalPrestasi ?? 0 }}
                </span>
            </a>

            <a href="{{ url('/orangtua/laporan?jenis=pelanggaran') }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition
               {{ request('jenis') == 'pelanggaran' ? 'bg-red-500 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                ⚠️ Pelanggaran
                <span class="ml-1">
                    {{ $totalPelanggaran ?? 0 }}
                </span>
            </a>

            <a href="{{ url('/orangtua/laporan?jenis=informasi') }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition
               {{ request('jenis') == 'informasi' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}">
                ℹ️ Informasi
                <span class="ml-1">
                    {{ $totalInformasi ?? 0 }}
                </span>
            </a>

        </div>

    </div>

    <!-- RIWAYAT LAPORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
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

            <p class="text-gray-500 mt-1">
                Daftar laporan prestasi, pelanggaran, dan informasi yang telah diinput oleh guru/admin.
            </p>
        </div>

        <div class="space-y-5">

            @forelse ($laporans as $laporan)

                <div class="border rounded-2xl p-6 bg-[#F8FBF9] hover:shadow-md transition">

                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                        <div>

                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                {{ $laporan->jenis == 'prestasi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $laporan->jenis == 'pelanggaran' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $laporan->jenis == 'informasi' ? 'bg-blue-100 text-blue-700' : '' }}">

                                @if ($laporan->jenis == 'prestasi')
                                    🏆 Prestasi
                                @elseif ($laporan->jenis == 'pelanggaran')
                                    ⚠️ Pelanggaran
                                @else
                                    ℹ️ Informasi
                                @endif

                            </span>

                            <h3 class="text-xl font-bold text-gray-800 mt-4">
                                {{ $laporan->judul }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-2">
                                {{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : '-' }}

                                @if ($laporan->tingkat)
                                    • {{ $laporan->tingkat }}
                                @endif
                            </p>

                        </div>

                        <div class="text-sm text-gray-400">
                            Dibuat: {{ $laporan->created_at ? $laporan->created_at->format('d M Y') : '-' }}
                        </div>

                    </div>

                    <p class="text-gray-600 mt-5 leading-relaxed">
                        {{ $laporan->deskripsi }}
                    </p>

                    <!-- LAMPIRAN PRESTASI -->
                    @if ($laporan->jenis == 'prestasi' && !empty($laporan->sertifikat))

                        @php
                            $fileUrl = asset('storage/' . $laporan->sertifikat);
                            $extension = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                        @endphp

                        <div class="mt-5 bg-white rounded-2xl p-4 border border-gray-100">

                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm text-gray-500">
                                    Lampiran Prestasi
                                </p>

                                <a href="{{ $fileUrl }}"
                                   target="_blank"
                                   class="text-sm font-semibold text-[#2F7D55] hover:underline">
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
                                   class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-5 py-3 rounded-xl font-semibold hover:bg-yellow-200 transition">
                                    📄 Lihat Lampiran PDF
                                </a>

                            @else

                                <a href="{{ $fileUrl }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-5 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                                    📎 Unduh Lampiran
                                </a>

                            @endif

                        </div>

                    @endif

                    @if ($laporan->catatan)
                        <div class="mt-5 bg-white rounded-2xl p-4 border border-gray-100">
                            <p class="text-sm text-gray-500 mb-1">
                                Catatan Guru/Admin
                            </p>

                            <p class="text-gray-700">
                                {{ $laporan->catatan }}
                            </p>
                        </div>
                    @endif

                </div>

            @empty

                <div class="text-center py-12">

                    <div class="text-5xl mb-4">
                        📭
                    </div>

                    <h3 class="text-xl font-bold text-gray-800">
                        Belum ada laporan
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Laporan prestasi, pelanggaran, atau informasi siswa akan muncul di sini.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
