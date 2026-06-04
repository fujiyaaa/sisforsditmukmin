@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-[#1F252D]">
           Rekapitulasi Absensi
        </h1>
    </div>

    <!-- CARD PROFIL -->
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div class="flex items-center gap-5">

                <div class="w-24 h-24 rounded-2xl bg-[#2F7D55] flex items-center justify-center text-white text-5xl">
                    🎓
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-[#1F252D]">
                        {{ $siswa->nama ?? '-' }}
                    </h2>

                    <p class="text-[#2F7D55] mt-2 font-semibold">
                        NIS : {{ $siswa->nis ?? '-' }}
                        |
                        Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
                    </p>

                </div>

            </div>

            <div class="flex gap-8">

                <div class="text-center">
                    <h3 class="text-5xl font-bold text-[#1F6B4A]">
                        {{ $persentaseHadir ?? 0 }}%
                    </h3>

                    <p class="text-gray-500 font-semibold mt-1">
                        Kehadiran
                    </p>
                </div>

                <div class="text-center">
                    <h3 class="text-5xl font-bold text-yellow-600">
                        {{ $totalTerlambat ?? 0 }}
                    </h3>

                    <p class="text-gray-500 font-semibold mt-1">
                        Terlambat
                    </p>
                </div>

            </div>

        </div>

    </div>

    <!-- STATISTIK KECIL -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <p class="text-gray-500 text-sm">Hadir</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $totalHadir ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <p class="text-gray-500 text-sm">Izin</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $totalIzin ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <p class="text-gray-500 text-sm">Sakit</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $totalSakit ?? 0 }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <p class="text-gray-500 text-sm">Alpha</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">
                {{ $totalAlpha ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- FILTER TANGGAL -->
    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">

        <form method="GET"
              action="{{ route('orangtua.absensi') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Pilih Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal') }}"
                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#3F8260] transition">
                    Filter Tanggal
                </button>
            </div>

            <div class="flex items-end">
                <a href="{{ route('orangtua.absensi') }}"
                   class="w-full text-center bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <!-- RIWAYAT ABSENSI -->
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

        <div class="px-8 py-6 border-b flex items-center gap-3">
            <span class="text-3xl">↺</span>

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Riwayat Absensi
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Daftar absensi ananda yang telah diinput oleh guru.
                </p>

                @if (request('tanggal'))
                    <p class="text-sm text-[#2F7D55] font-semibold mt-2">
                        Menampilkan absensi tanggal:
                        {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100 text-gray-600">
                    <tr>
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

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-5 font-semibold text-gray-800">
                                {{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l') : '-' }}
                            </td>

                            <td class="px-6 py-5">

                                @if ($absensi->status == 'hadir')
                                    <span class="inline-block min-w-[90px] text-center px-4 py-2 rounded-xl bg-green-100 text-green-700 border border-green-200 font-semibold">
                                        Hadir
                                    </span>
                                @elseif ($absensi->status == 'izin')
                                    <span class="inline-block min-w-[90px] text-center px-4 py-2 rounded-xl bg-yellow-100 text-yellow-700 border border-yellow-200 font-semibold">
                                        Izin
                                    </span>
                                @elseif ($absensi->status == 'sakit')
                                    <span class="inline-block min-w-[90px] text-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 border border-blue-200 font-semibold">
                                        Sakit
                                    </span>
                                @elseif ($absensi->status == 'alpha')
                                    <span class="inline-block min-w-[90px] text-center px-4 py-2 rounded-xl bg-red-100 text-red-700 border border-red-200 font-semibold">
                                        Alpha
                                    </span>
                                @else
                                    <span class="inline-block min-w-[90px] text-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 border border-gray-200 font-semibold">
                                        {{ ucfirst($absensi->status ?? '-') }}
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-5 font-semibold text-gray-700">
                                {{ $absensi->waktu_absen ?? '-' }}
                            </td>

                            <td class="px-6 py-5">

                                @if ($absensi->keterlambatan && $absensi->keterlambatan > 0)
                                    <span class="font-semibold text-yellow-600">
                                        {{ $absensi->keterlambatan }} menit
                                    </span>
                                @else
                                    <span class="font-semibold text-gray-700">
                                        Tepat Waktu
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $absensi->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500">
                                Belum ada data absensi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
