@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    <!-- HERO HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    ABSENSI SISWA
                </div>

                <h1 class="text-4xl font-bold">
                    Absensi Kehadiran Siswa
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Input status kehadiran, waktu absen, keterlambatan, dan keterangan siswa.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Tanggal Aktif
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Rekap Absensi Siswa
                </p>

                <p class="text-white/60 text-xs mt-1">
                    Input kehadiran harian
                </p>
            </div>

        </div>

    </div>

    {{-- FILTER KELAS --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Absensi
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas dan tanggal untuk menampilkan daftar siswa.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('guru.absensi.index') }}"
                  class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full lg:max-w-4xl">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Kelas
                    </label>

                    <select name="kelas_id"
                            class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                        <option value="">Pilih Kelas</option>

                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ (string) $kelasId === (string) $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas ?? $kelas->kelas ?? 'Kelas' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ $tanggal }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-4 rounded-2xl font-semibold transition shadow-sm">
                        Tampilkan Siswa
                    </button>
                </div>

            </form>

        </div>

    </div>

    @if ($kelasId)

        {{-- INFO KELAS --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                <div class="flex items-center gap-4">

                    <div class="w-16 h-16 rounded-3xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold">
                        K
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Kelas Aktif
                        </p>

                        <h2 class="text-2xl font-bold text-[#1F252D]">
                            @php
                                $kelasAktif = $kelasList->firstWhere('id', $kelasId);
                            @endphp

                            {{ $kelasAktif->nama_kelas ?? $kelasAktif->kelas ?? '-' }}
                        </h2>

                        <p class="text-sm text-[#2F7D55] mt-1 font-semibold">
                            Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
                        </p>
                    </div>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 xl:min-w-[620px]">

                    <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5 text-center">
                        <p class="text-sm text-gray-500">Total</p>
                        <h3 class="text-3xl font-bold text-[#2F7D55] mt-2">{{ $totalSiswa }}</h3>
                    </div>

                    <div class="rounded-3xl bg-green-50 border border-green-100 p-5 text-center">
                        <p class="text-sm text-gray-500">Hadir</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $hadir }}</h3>
                    </div>

                    <div class="rounded-3xl bg-blue-50 border border-blue-100 p-5 text-center">
                        <p class="text-sm text-gray-500">Izin</p>
                        <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $izin }}</h3>
                    </div>

                    <div class="rounded-3xl bg-yellow-50 border border-yellow-100 p-5 text-center">
                        <p class="text-sm text-gray-500">Sakit</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-2">{{ $sakit }}</h3>
                    </div>

                    <div class="rounded-3xl bg-red-50 border border-red-100 p-5 text-center">
                        <p class="text-sm text-gray-500">Alpha</p>
                        <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $alpha }}</h3>
                    </div>

                </div>

            </div>

        </div>

        {{-- FORM ABSENSI --}}
        <form method="POST"
              action="{{ route('guru.absensi.store') }}"
              class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            @csrf

            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Daftar Siswa
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Isi status kehadiran siswa pada tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}.
                    </p>
                </div>

                <button type="submit"
                        class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-7 py-4 rounded-2xl font-semibold transition shadow-sm">
                    Simpan Semua
                </button>

            </div>

            @if ($errors->any())
                <div class="mx-8 mt-6 bg-red-50 border border-red-100 text-red-700 rounded-[1.5rem] p-6">

                    <h3 class="font-bold mb-3">
                        Data belum lengkap
                    </h3>

                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1200px]">

                    <thead>
                        <tr class="bg-[#4D9A72] text-white">
                            <th class="px-6 py-4 text-left font-semibold">No</th>
                            <th class="px-6 py-4 text-left font-semibold">NIS</th>
                            <th class="px-6 py-4 text-left font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Waktu Absen</th>
                            <th class="px-6 py-4 text-left font-semibold">Keterlambatan</th>
                            <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($siswas as $siswa)

                            @php
                                $absen = $absensiHariIni->get($siswa->id);
                            @endphp

                            <tr class="hover:bg-[#FAFCFB] transition">

                                <td class="px-6 py-5 text-gray-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-700 whitespace-nowrap">
                                    {{ $siswa->nis ?? '-' }}
                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold shrink-0">
                                            {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                                        </div>

                                        <div>
                                            <h4 class="font-bold text-[#1F252D]">
                                                {{ $siswa->nama ?? '-' }}
                                            </h4>

                                            <p class="text-sm text-gray-400">
                                                Siswa
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-5">
                                    <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">

                                    <select name="status[{{ $siswa->id }}]"
                                            class="w-36 px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                                        <option value="hadir" {{ ($absen->status ?? 'hadir') == 'hadir' ? 'selected' : '' }}>
                                            Hadir
                                        </option>

                                        <option value="izin" {{ ($absen->status ?? '') == 'izin' ? 'selected' : '' }}>
                                            Izin
                                        </option>

                                        <option value="sakit" {{ ($absen->status ?? '') == 'sakit' ? 'selected' : '' }}>
                                            Sakit
                                        </option>

                                        <option value="alpha" {{ ($absen->status ?? '') == 'alpha' ? 'selected' : '' }}>
                                            Alpha
                                        </option>
                                    </select>
                                </td>

                                <td class="px-6 py-5">
                                    <input type="time"
                                           name="waktu_absen[{{ $siswa->id }}]"
                                           value="{{ $absen->waktu_absen ?? '06:30' }}"
                                           class="w-36 px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <input type="number"
                                               name="keterlambatan[{{ $siswa->id }}]"
                                               value="{{ $absen->keterlambatan ?? 0 }}"
                                               min="0"
                                               class="w-28 px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">

                                        <span class="text-sm text-gray-500">
                                            menit
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <input type="text"
                                           name="keterangan[{{ $siswa->id }}]"
                                           value="{{ $absen->keterangan ?? '' }}"
                                           placeholder="Opsional"
                                           class="w-56 px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="py-14">

                                    <div class="text-center">

                                        <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                                            0
                                        </div>

                                        <h3 class="text-xl font-bold text-gray-700">
                                            Tidak ada siswa
                                        </h3>

                                        <p class="text-gray-500 mt-2">
                                            Tidak ada siswa pada kelas yang dipilih.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </form>

    @else

        {{-- EMPTY STATE --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-12 text-center">

            <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                K
            </div>

            <h2 class="text-2xl font-bold text-[#1F252D]">
                Pilih kelas terlebih dahulu
            </h2>

            <p class="text-gray-500 mt-2">
                Setelah kelas dipilih, daftar siswa akan muncul untuk input absensi.
            </p>

        </div>

    @endif

    {{-- RIWAYAT ABSENSI --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Riwayat Absensi
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Daftar absensi siswa yang sudah pernah disimpan.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $riwayatAbsensi->count() ?? 0 }} Data
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1200px]">

                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">NIS</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 text-left font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu Absen</th>
                        <th class="px-6 py-4 text-left font-semibold">Terlambat</th>
                        <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($riwayatAbsensi as $absen)

                        @php
                            $statusClass = 'bg-red-50 text-red-700 border-red-100';
                            $statusLabel = 'Alpha';

                            if ($absen->status == 'hadir') {
                                $statusClass = 'bg-green-50 text-green-700 border-green-100';
                                $statusLabel = 'Hadir';
                            } elseif ($absen->status == 'izin') {
                                $statusClass = 'bg-blue-50 text-blue-700 border-blue-100';
                                $statusLabel = 'Izin';
                            } elseif ($absen->status == 'sakit') {
                                $statusClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                $statusLabel = 'Sakit';
                            }
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition">

                            <td class="px-6 py-5 text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-5 font-semibold text-[#1F252D] whitespace-nowrap">
                                {{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-700 whitespace-nowrap">
                                {{ $absen->siswa->nis ?? '-' }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold shrink-0">
                                        {{ strtoupper(substr($absen->siswa->nama ?? '-', 0, 1)) }}
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-[#1F252D]">
                                            {{ $absen->siswa->nama ?? '-' }}
                                        </h4>

                                        <p class="text-sm text-gray-400">
                                            Siswa
                                        </p>
                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-5 text-gray-600 whitespace-nowrap">
                                {{ $absen->siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex min-w-[90px] items-center justify-center px-4 py-2 rounded-2xl border text-sm font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-gray-700 whitespace-nowrap">
                                {{ $absen->waktu_absen ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                @if (($absen->keterlambatan ?? 0) > 0)
                                    <span class="inline-flex items-center justify-center bg-yellow-50 text-yellow-700 border border-yellow-100 px-4 py-2 rounded-2xl text-sm font-semibold">
                                        {{ $absen->keterlambatan }} menit
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] border border-[#DDF3E7] px-4 py-2 rounded-2xl text-sm font-semibold">
                                        Tepat Waktu
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-gray-600 min-w-[220px]">
                                {{ $absen->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="py-14">

                                <div class="text-center">

                                    <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                                        0
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-700">
                                        Belum ada riwayat absensi
                                    </h3>

                                    <p class="text-gray-500 mt-2">
                                        Riwayat absensi akan muncul setelah data disimpan.
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

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonText: 'Oke',
                confirmButtonColor: '#2F7D55'
            });
        });
    </script>
@endif

@endsection
