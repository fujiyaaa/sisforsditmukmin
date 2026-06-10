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
                    SETORAN QURAN
                </div>

                <h1 class="text-4xl font-bold">
                    Monitoring Setoran Quran
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Pilih siswa untuk menginput setoran Tahfidz, Murajaah, atau Tilawah.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Menu Aktif
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    Setoran Quran
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Tahfidz, Murajaah, Tilawah
                </p>

                <a href="{{ route('setoran.riwayat') }}"
                class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                    Riwayat Setoran
                </a>
            </div>

        </div>

    </div>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#2F7D55'
                });
            });
        </script>
    @endif

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Kelas
                </h2>

                <p class="text-gray-500 mt-1">
                    Tampilkan siswa berdasarkan kelas yang diampu.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('setoran.index') }}"
                  class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full lg:max-w-3xl">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pilih Kelas
                    </label>

                    <select name="kelas_id"
                            class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                        <option value="">Semua Kelas</option>

                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" {{ (string) $kelas_id === (string) $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-4 rounded-2xl font-semibold transition shadow-sm">
                        Filter
                    </button>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('setoran.index') }}"
                       class="w-full text-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold transition">
                        Reset
                    </a>
                </div>

            </form>

        </div>

    </div>

    {{-- DAFTAR SISWA --}}
    <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

        @php
            $daftarSiswaByKelas = isset($siswasByKelas)
                ? $siswasByKelas
                : collect($siswas)
                    ->filter(function ($item) {
                        return is_object($item);
                    })
                    ->groupBy(function ($siswa) {
                        return $siswa->kelas->nama_kelas ?? '-';
                    });

            $totalSiswa = $daftarSiswaByKelas->flatten(1)->count();
        @endphp

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Klik tombol input untuk menambahkan setoran Quran siswa.
                </p>
            </div>

            <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $totalSiswa }} Siswa
            </div>

        </div>

        @if($totalSiswa > 0)

            <div class="overflow-x-auto rounded-3xl border border-gray-100">

                <table class="w-full min-w-[1000px] table-fixed">

                    <thead class="bg-[#4D9A72] text-white">
                        <tr>
                            <th class="w-[80px] px-6 py-4 text-left font-semibold">
                                No
                            </th>

                            <th class="w-[180px] px-6 py-4 text-left font-semibold">
                                NIS
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Nama Siswa
                            </th>

                            <th class="w-[180px] px-6 py-4 text-left font-semibold">
                                Kelas
                            </th>

                            <th class="w-[220px] px-6 py-4 text-center font-semibold">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @php
                            $no = 1;
                        @endphp

                        @foreach($daftarSiswaByKelas as $namaKelas => $daftarSiswa)

                            <tr>
                                <td colspan="5" class="bg-[#F8FBF9] px-6 py-4 border-b border-gray-100">
                                    <h3 class="font-bold text-[#2F7D55]">
                                        Kelas {{ $namaKelas }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ collect($daftarSiswa)->count() }} siswa
                                    </p>
                                </td>
                            </tr>

                            @foreach($daftarSiswa as $siswa)

                                <tr class="hover:bg-[#F8FBF9] transition">

                                    <td class="px-6 py-5 text-gray-600 align-middle">
                                        {{ $no++ }}
                                    </td>

                                    <td class="px-6 py-5 text-gray-700 font-medium align-middle">
                                        {{ $siswa->nis }}
                                    </td>

                                    <td class="px-6 py-5 align-middle">
                                        <div class="flex items-center gap-4">

                                            <div class="w-12 h-12 rounded-full bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-lg shrink-0">
                                                {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">
                                                <h4 class="font-bold text-[#1F252D] truncate">
                                                    {{ $siswa->nama }}
                                                </h4>

                                                <p class="text-sm text-gray-400 mt-1">
                                                    Siswa
                                                </p>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-middle">
                                        <span class="inline-flex items-center bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-semibold">
                                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center align-middle">
                                        <a href="{{ route('setoran.create', $siswa->nis) }}"
                                        class="inline-flex items-center justify-center bg-[#4D9A72] hover:bg-[#2F6F4F] text-white px-5 py-3 rounded-2xl font-semibold transition">
                                            Input Setoran
                                        </a>
                                    </td>

                                </tr>

                            @endforeach

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
                    Data siswa belum tersedia untuk filter kelas ini.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
