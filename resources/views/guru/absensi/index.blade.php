@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <h1 class="text-3xl font-bold text-[#1F6B4A]">
                Absensi Kehadiran Siswa
            </h1>

            <p class="text-gray-500 mt-2">
                Input waktu absen manual dan keterlambatan siswa.
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

    <!-- FILTER KELAS -->
    <div class="bg-[#D8F3E4] rounded-3xl shadow-lg p-8 border border-[#BDE8D1]">

        <div class="flex items-center gap-3 mb-5">
            <div class="bg-[#2F6F4F] text-white w-12 h-12 rounded-2xl flex items-center justify-center text-2xl">
                👥
            </div>

            <h2 class="text-2xl font-bold text-gray-800">
                Pilih Kelas
            </h2>
        </div>

        <form method="GET" action="{{ route('guru.absensi.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-[#4D9A72] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas ?? $kelas->kelas ?? 'Kelas' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ $tanggal }}"
                       class="w-full px-4 py-3 border border-[#4D9A72] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F6F4F] text-white px-6 py-3 rounded-xl hover:bg-[#265B40] transition font-semibold">
                    Tampilkan Siswa
                </button>
            </div>

        </form>

    </div>

    @if ($kelasId)

        <!-- INFO KELAS -->
        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-5">

            <div class="flex items-center gap-4">
                <div class="bg-[#2F6F4F] text-white w-12 h-12 rounded-2xl flex items-center justify-center text-2xl">
                    🖥️
                </div>

                <div>
                    <p class="text-gray-500 text-sm">
                        Kelas aktif
                    </p>

                    <h2 class="text-2xl font-bold text-gray-800">
                        @php
                            $kelasAktif = $kelasList->firstWhere('id', $kelasId);
                        @endphp

                        {{ $kelasAktif->nama_kelas ?? $kelasAktif->kelas ?? '-' }}
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">

                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <h3 class="font-bold text-[#2F6F4F]">{{ $totalSiswa }}</h3>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Hadir</p>
                    <h3 class="font-bold text-green-600">{{ $hadir }}</h3>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Izin</p>
                    <h3 class="font-bold text-blue-600">{{ $izin }}</h3>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Sakit</p>
                    <h3 class="font-bold text-yellow-600">{{ $sakit }}</h3>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Alpha</p>
                    <h3 class="font-bold text-red-600">{{ $alpha }}</h3>
                </div>

            </div>

        </div>

        <!-- FORM ABSENSI -->
        <form method="POST" action="{{ route('guru.absensi.store') }}" class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
            @csrf

            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Daftar Siswa
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Isi status kehadiran siswa pada tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}.
                    </p>
                </div>

                <button type="submit"
                        class="bg-[#2F6F4F] text-white px-6 py-3 rounded-xl hover:bg-[#265B40] transition font-semibold">
                    💾 Simpan Semua
                </button>

            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 rounded-2xl p-5 mb-6">
                    <h3 class="font-bold mb-2">Data belum lengkap:</h3>

                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-[#4D9A72] text-white">
                            <th class="px-4 py-3 text-left rounded-l-xl">No</th>
                            <th class="px-4 py-3 text-left">NIS</th>
                            <th class="px-4 py-3 text-left">Nama Siswa</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Waktu Absen</th>
                            <th class="px-4 py-3 text-left">Keterlambatan</th>
                            <th class="px-4 py-3 text-left rounded-r-xl">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($siswas as $siswa)

                            @php
                                $absen = $absensiHariIni->get($siswa->id);
                            @endphp

                            <tr class="border-b hover:bg-gray-50 transition">

                                <td class="px-4 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-4 text-gray-700">
                                    {{ $siswa->nis }}
                                </td>

                                <td class="px-4 py-4 font-semibold text-gray-800">
                                    {{ $siswa->nama }}
                                </td>

                                <td class="px-4 py-4">
                                    <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">

                                    <select name="status[{{ $siswa->id }}]"
                                            class="px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                                        <option value="hadir" {{ ($absen->status ?? 'hadir') == 'hadir' ? 'selected' : '' }}>
                                            ● Hadir
                                        </option>

                                        <option value="izin" {{ ($absen->status ?? '') == 'izin' ? 'selected' : '' }}>
                                            ● Izin
                                        </option>

                                        <option value="sakit" {{ ($absen->status ?? '') == 'sakit' ? 'selected' : '' }}>
                                            ● Sakit
                                        </option>

                                        <option value="alpha" {{ ($absen->status ?? '') == 'alpha' ? 'selected' : '' }}>
                                            ● Alpha
                                        </option>
                                    </select>
                                </td>

                                <td class="px-4 py-4">
                                    <input type="time"
                                           name="waktu_absen[{{ $siswa->id }}]"
                                           value="{{ $absen->waktu_absen ?? '06:30' }}"
                                           class="w-32 px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <input type="number"
                                               name="keterlambatan[{{ $siswa->id }}]"
                                               value="{{ $absen->keterlambatan ?? 0 }}"
                                               min="0"
                                               class="w-24 px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                                        <span class="text-xs text-gray-500">
                                            menit
                                        </span>
                                    </div>
                                </td>

                                <td class="px-4 py-4">
                                    <input type="text"
                                           name="keterangan[{{ $siswa->id }}]"
                                           value="{{ $absen->keterangan ?? '' }}"
                                           placeholder="Opsional"
                                           class="w-48 px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    Tidak ada siswa pada kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </form>

    @else

        <!-- EMPTY STATE -->
        <div class="bg-white rounded-3xl shadow-lg p-12 border border-gray-100 text-center">

            <div class="text-6xl mb-4">
                📋
            </div>

            <h2 class="text-2xl font-bold text-gray-800">
                Pilih kelas terlebih dahulu
            </h2>

            <p class="text-gray-500 mt-2">
                Setelah kelas dipilih, daftar siswa akan muncul untuk input absensi.
            </p>

        </div>

    @endif

    <!-- RIWAYAT ABSENSI -->
    <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Riwayat Absensi
                </h2>

                <p class="text-gray-500 mt-1">
                    Daftar absensi siswa yang sudah pernah disimpan.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#2F6F4F] text-white">
                        <th class="px-4 py-3 text-left rounded-l-xl">No</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">NIS</th>
                        <th class="px-4 py-3 text-left">Nama Siswa</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Waktu Absen</th>
                        <th class="px-4 py-3 text-left">Terlambat</th>
                        <th class="px-4 py-3 text-left rounded-r-xl">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($riwayatAbsensi as $absen)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-4">
                                {{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $absen->siswa->nis ?? '-' }}
                            </td>

                            <td class="px-4 py-4 font-semibold text-gray-800">
                                {{ $absen->siswa->nama ?? '-' }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $absen->siswa->kelas->nama_kelas ?? $absen->siswa->kelas ?? '-' }}
                            </td>

                            <td class="px-4 py-4">
                                @if ($absen->status == 'hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                        Hadir
                                    </span>
                                @elseif ($absen->status == 'izin')
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                                        Izin
                                    </span>
                                @elseif ($absen->status == 'sakit')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                                        Sakit
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                        Alpha
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-4">
                                {{ $absen->waktu_absen ?? '-' }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $absen->keterlambatan ?? 0 }} menit
                            </td>

                            <td class="px-4 py-4">
                                {{ $absen->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                Belum ada riwayat absensi.
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
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#4D9A72'
        });
    </script>
@endif

@endsection
