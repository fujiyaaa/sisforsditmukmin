@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    {{-- HERO HEADER --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    ADMIN ABSENSI
                </div>

                <h1 class="text-4xl font-bold">
                    Absensi Kehadiran Siswa
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Input status kehadiran, waktu absen, dan keterlambatan siswa untuk semua kelas.
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
                    Admin dapat akses semua kelas
                </p>

                <p class="text-white/60 text-xs mt-1">
                    Absensi siswa
                </p>
            </div>

        </div>

    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="bg-[#EEF7F1] border border-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl">

            <p class="font-bold mb-2">
                Data belum sesuai:
            </p>

            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- FILTER --}}
    <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Absensi
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas dan tanggal untuk menampilkan data siswa.
                </p>
            </div>

            <a href="{{ route('admin.absensi.index') }}"
               class="bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl hover:bg-gray-200 transition text-center font-semibold">
                Reset Filter
            </a>

        </div>

        <form method="GET"
              action="{{ route('admin.absensi.index') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                    <option value="">
                        Pilih Kelas
                    </option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ $kelasId == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
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
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition font-semibold">
                    Tampilkan
                </button>
            </div>

            <div class="flex items-end">
                <div class="w-full bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold text-center">
                    {{ $totalSiswa }} Siswa
                </div>
            </div>

        </form>

        <div class="mt-6 bg-[#EEF7F1] border border-gray-100 rounded-2xl p-5">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                <div>
                    <p class="font-bold text-[#2F7D55]">
                        Absensi Kehadiran
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Admin dapat menginput dan memperbarui data absensi siswa berdasarkan kelas dan tanggal.
                    </p>
                </div>

                <div class="bg-white text-[#2F7D55] px-4 py-2 rounded-2xl font-bold text-sm tracking-wide">
                    ABSENSI
                </div>

            </div>

        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- KELAS AKTIF --}}
        <div class="xl:col-span-1 bg-white rounded-3xl shadow-md p-8 border border-gray-100">

            <div class="flex items-start justify-between gap-4 mb-5">

                <div>
                    <p class="text-gray-500">
                        Kelas Aktif
                    </p>

                    <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                        {{ $kelasAktif->nama_kelas ?? '-' }}
                    </h2>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-bold text-sm">
                    {{ $totalSiswa }} siswa
                </div>

            </div>

            <p class="text-gray-500">
                {{ $kelasAktif ? 'Data siswa pada kelas yang dipilih.' : 'Silakan pilih kelas terlebih dahulu.' }}
            </p>

        </div>

        {{-- STATUS ABSENSI --}}
        <div class="xl:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <div class="border-l-4 border-[#4D9A72] pl-5">
                    <p class="text-gray-500">
                        Hadir
                    </p>

                    <h2 class="text-4xl font-bold text-[#2F7D55] mt-2">
                        {{ $totalHadir }}
                    </h2>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <div class="border-l-4 border-yellow-500 pl-5">
                    <p class="text-gray-500">
                        Izin
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-600 mt-2">
                        {{ $totalIzin }}
                    </h2>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <div class="border-l-4 border-blue-600 pl-5">
                    <p class="text-gray-500">
                        Sakit
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-2">
                        {{ $totalSakit }}
                    </h2>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <div class="border-l-4 border-red-600 pl-5">
                    <p class="text-gray-500">
                        Alfa
                    </p>

                    <h2 class="text-4xl font-bold text-red-600 mt-2">
                        {{ $totalAlfa }}
                    </h2>
                </div>
            </div>

        </div>

    </div>

    {{-- FORM ABSENSI --}}
    <form method="POST"
          action="{{ route('admin.absensi.store') }}"
          class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">
        @csrf

        <input type="hidden" name="tanggal" value="{{ $tanggal }}">
        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Isi status kehadiran siswa pada tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}.
                </p>
            </div>

            @if($siswas->count() > 0)
                <button type="submit"
                        class="bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition font-semibold">
                    Simpan Absensi
                </button>
            @endif

        </div>

        @if ($siswas->count() > 0)

            <div class="overflow-x-auto rounded-3xl border border-gray-100">

                <table class="w-full min-w-[1200px]">

                    <thead class="bg-[#4D9A72] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">No</th>
                            <th class="px-6 py-4 text-left font-semibold">NIS</th>
                            <th class="px-6 py-4 text-left font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 text-left font-semibold">Status</th>
                            <th class="px-6 py-4 text-left font-semibold">Waktu Absen</th>
                            <th class="px-6 py-4 text-left font-semibold">Keterlambatan</th>
                            <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach ($siswas as $index => $siswa)

                            @php
                                $absensi = $absensiHariIni[$siswa->id] ?? null;
                            @endphp

                            <tr class="hover:bg-[#F8FBF9] transition">

                                <td class="px-6 py-5 text-gray-600">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-5 text-gray-700 font-medium">
                                    {{ $siswa->nis }}
                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="w-12 h-12 rounded-full bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-lg">
                                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                        </div>

                                        <div>
                                            <h4 class="font-bold text-[#1F252D]">
                                                {{ $siswa->nama }}
                                            </h4>

                                            <p class="text-sm text-gray-400 mt-1">
                                                Siswa Aktif
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-5">
                                    <select name="status[{{ $siswa->id }}]"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                                        <option value="hadir" {{ ($absensi->status ?? '') == 'hadir' ? 'selected' : '' }}>
                                            Hadir
                                        </option>

                                        <option value="izin" {{ ($absensi->status ?? '') == 'izin' ? 'selected' : '' }}>
                                            Izin
                                        </option>

                                        <option value="sakit" {{ ($absensi->status ?? '') == 'sakit' ? 'selected' : '' }}>
                                            Sakit
                                        </option>

                                        <option value="alpha" {{ ($absensi->status ?? '') == 'alpha' ? 'selected' : '' }}>
                                            Alpha
                                        </option>
                                    </select>
                                </td>

                                <td class="px-6 py-5">
                                    <input type="time"
                                           name="waktu_absen[{{ $siswa->id }}]"
                                           value="{{ $absensi->waktu_absen ?? '06:30' }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <input type="number"
                                               name="keterlambatan[{{ $siswa->id }}]"
                                               value="{{ $absensi->keterlambatan ?? 0 }}"
                                               min="0"
                                               class="w-24 px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">

                                        <span class="text-sm text-gray-500">
                                            menit
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <input type="text"
                                           name="keterangan[{{ $siswa->id }}]"
                                           value="{{ $absensi->keterangan ?? '' }}"
                                           placeholder="Opsional"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-16 bg-[#F8FBF9] rounded-3xl border border-dashed border-gray-200">

                <div class="w-16 h-16 mx-auto rounded-full bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                    0
                </div>

                <h3 class="text-xl font-bold text-[#1F252D]">
                    Belum Ada Data Siswa
                </h3>

                <p class="text-gray-500 mt-2">
                    Pilih kelas terlebih dahulu untuk menampilkan daftar siswa.
                </p>

            </div>

        @endif

    </form>

</div>

@endsection
