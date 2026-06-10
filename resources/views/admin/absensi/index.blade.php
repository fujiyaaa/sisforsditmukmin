@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F5F43] via-[#2F7D55] to-[#75C295] p-8 shadow-lg text-white">
        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-[#DDF3E7]/20 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-8">
            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-xs font-bold tracking-[0.2em] mb-5">
                    ADMIN ABSENSI
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Absensi Kehadiran Siswa
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Input status kehadiran, waktu absen, dan keterlambatan siswa untuk semua kelas.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[250px] border border-white/15">
                <p class="text-sm text-white/70">
                    Hari Ini
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}
                </h2>

                <p class="text-white/70 text-sm mt-1">
                    Admin dapat akses semua kelas
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FILTER -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Pilih Kelas
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas dan tanggal untuk menampilkan data siswa.
                </p>
            </div>

            <a href="{{ route('admin.absensi.index') }}"
               class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl hover:bg-[#DDF3E7] transition text-center font-bold">
                Reset Filter
            </a>
        </div>

        <form method="GET"
              action="{{ route('admin.absensi.index') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
                    <option value="">-- Pilih Kelas --</option>

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
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F7D55] text-white px-6 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold shadow-sm">
                    Tampilkan Siswa
                </button>
            </div>
        </form>
    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">
                        Kelas Aktif
                    </p>

                    <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                        {{ $kelasAktif->nama_kelas ?? '-' }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-2">
                        {{ $kelasAktif ? 'Data siswa pada kelas yang dipilih' : 'Silakan pilih kelas terlebih dahulu' }}
                    </p>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-bold text-sm">
                    {{ $totalSiswa }} siswa
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="border-l-4 border-[#4D9A72] pl-4">
                <p class="text-sm text-gray-500">Hadir</p>
                <h3 class="text-3xl font-bold text-[#2F7D55] mt-2">{{ $totalHadir }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="border-l-4 border-amber-400 pl-4">
                <p class="text-sm text-gray-500">Izin</p>
                <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $totalIzin }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="grid grid-cols-2 gap-4">
                <div class="border-l-4 border-sky-400 pl-4">
                    <p class="text-sm text-gray-500">Sakit</p>
                    <h3 class="text-2xl font-bold text-sky-600 mt-2">{{ $totalSakit }}</h3>
                </div>

                <div class="border-l-4 border-rose-400 pl-4">
                    <p class="text-sm text-gray-500">Alfa</p>
                    <h3 class="text-2xl font-bold text-rose-600 mt-2">{{ $totalAlfa }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <form method="POST"
          action="{{ route('admin.absensi.store') }}"
          class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">
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
                        class="bg-[#2F7D55] text-white px-6 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold shadow-sm">
                    Submit Absensi
                </button>
            @endif
        </div>

        @if ($siswas->count() > 0)
            <div class="overflow-x-auto rounded-[2rem] border border-gray-100">
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

                            <tr class="hover:bg-[#FAFCFB] transition">
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4 text-gray-700 font-medium">
                                    {{ $siswa->nis }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                        </div>

                                        <div>
                                            <h4 class="font-semibold text-[#1F252D]">
                                                {{ $siswa->nama }}
                                            </h4>

                                            <p class="text-sm text-gray-400">
                                                Siswa Aktif
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <select name="status[{{ $siswa->id }}]"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
                                        <option value="hadir" {{ ($absensi->status ?? '') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="izin" {{ ($absensi->status ?? '') == 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="sakit" {{ ($absensi->status ?? '') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="alfa" {{ ($absensi->status ?? '') == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                    </select>
                                </td>

                                <td class="px-6 py-4">
                                    <input type="time"
                                           name="waktu_absen[{{ $siswa->id }}]"
                                           value="{{ $absensi->waktu_absen ?? '06:30' }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <input type="number"
                                               name="keterlambatan[{{ $siswa->id }}]"
                                               value="{{ $absensi->keterlambatan ?? 0 }}"
                                               min="0"
                                               class="w-24 px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
                                        <span class="text-sm text-gray-500">menit</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <input type="text"
                                           name="keterangan[{{ $siswa->id }}]"
                                           value="{{ $absensi->keterangan ?? '' }}"
                                           placeholder="Opsional"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        @else
            <div class="text-center py-16 bg-[#FAFCFB] rounded-[2rem] border border-dashed border-gray-200">
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
