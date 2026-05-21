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
                Monitoring Hafalan Ananda
            </h1>

            <p class="text-gray-500 mt-2">
                {{ $siswa->nama ?? '-' }} | Kelas {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
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

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Total Setoran
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalSetoran ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    📖
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Tahfidz
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalTahfidz ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    🕌
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Tilawah
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ $totalTilawah ?? 0 }}
                    </h2>
                </div>

                <div class="text-4xl">
                    📚
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">
                        Rata-rata Nilai
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-3">
                        {{ number_format($rataNilai ?? 0, 0) }}
                    </h2>
                </div>

                <div class="text-4xl">
                    ⭐
                </div>
            </div>
        </div>

    </div>

    <!-- RIWAYAT SETORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Riwayat Setoran Terbaru
                </h2>

                <p class="text-gray-500 mt-1">
                    Daftar setoran Quran yang sudah diinput oleh guru.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-4 py-3 text-left rounded-l-xl">Tanggal</th>
                        <th class="px-4 py-3 text-left">Jenis</th>
                        <th class="px-4 py-3 text-left">Surah</th>
                        <th class="px-4 py-3 text-left">Juz</th>
                        <th class="px-4 py-3 text-left">Nilai</th>
                        <th class="px-4 py-3 text-left rounded-r-xl">Catatan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($monitorings as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-gray-700">
                                {{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ strtolower($item->jenis) == 'tahfidz' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ strtolower($item->jenis) == 'tilawah' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ strtolower($item->jenis) == 'murajaah' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                    {{ ucfirst($item->jenis ?? '-') }}
                                </span>
                            </td>

                            <td class="px-4 py-4 font-semibold text-gray-800">
                                {{ $item->surah ?? '-' }}
                            </td>

                            <td class="px-4 py-4 text-gray-700">
                                {{ $item->juz ?? '-' }}
                            </td>

                            <td class="px-4 py-4">
                                <span class="font-bold text-[#2F7D55]">
                                    {{ $item->nilai ?? '-' }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-gray-600">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada riwayat setoran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- PROGRESS HAFALAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Progress Hafalan
            </h2>

            <p class="text-gray-500 mt-1">
                Ringkasan juz yang sudah pernah disetorkan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            @php
                $juzList = $monitorings->pluck('juz')->filter()->unique()->sortDesc();
            @endphp

            @forelse ($juzList as $juz)
                <div class="bg-[#EEF7F1] border border-[#D6EEE0] rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Juz
                            </p>

                            <h3 class="text-3xl font-bold text-[#2F7D55] mt-1">
                                {{ $juz }}
                            </h3>
                        </div>

                        <div class="text-3xl">
                            ✅
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-3 bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center text-gray-500">
                    Belum ada progress hafalan.
                </div>
            @endforelse

        </div>

    </div>

</div>

@endsection
