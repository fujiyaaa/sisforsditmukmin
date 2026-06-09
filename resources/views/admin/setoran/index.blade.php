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
                    ADMIN SETORAN QURAN
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Data Siswa Monitoring Quran
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Admin dapat melihat semua kelas dan menginput setoran Quran untuk seluruh siswa.
                </p>
            </div>

            <a href="{{ route('admin.setoran.riwayat') }}"
               class="bg-white text-[#2F7D55] px-6 py-3 rounded-2xl hover:bg-[#EEF7F1] transition font-bold">
                Riwayat Setoran
            </a>

        </div>

    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- FILTER -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Kelas
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas untuk menampilkan siswa tertentu.
                </p>
            </div>

            <a href="{{ route('admin.setoran.index') }}"
               class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl hover:bg-[#DDF3E7] transition text-center font-bold">
                Reset Filter
            </a>
        </div>

        <form method="GET"
              action="{{ route('admin.setoran.index') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold text-gray-700">
                    Pilih Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">

                    <option value="">
                        Semua Kelas
                    </option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F7D55] text-white px-6 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold shadow-sm">
                    Tampilkan Siswa
                </button>
            </div>

        </form>

    </div>

    <!-- TABLE SISWA -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih siswa untuk menginput setoran Quran.
                </p>
            </div>

            <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                {{ collect($siswas)->flatten(1)->count() }} siswa
            </div>
        </div>

        @if ($siswas->count() > 0)

            <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

                <table class="w-full min-w-[1000px]">

                    <thead class="bg-[#4D9A72] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">
                                No
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                NIS
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Nama Siswa
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Kelas
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @php
                            $no = 1;
                        @endphp

                        @foreach ($siswas as $kelasNama => $dataSiswa)

                            <tr>
                                <td colspan="5" class="bg-[#F8FBF9] px-6 py-4 font-bold text-[#1F252D]">
                                    Kelas {{ $kelasNama }}
                                </td>
                            </tr>

                            @foreach ($dataSiswa as $siswa)

                                <tr class="hover:bg-[#FAFCFB] transition">

                                    <td class="px-6 py-5 text-gray-700">
                                        {{ $no++ }}
                                    </td>

                                    <td class="px-6 py-5 text-gray-700 font-medium">
                                        {{ $siswa->nis }}
                                    </td>

                                    <td class="px-6 py-5">
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

                                    <td class="px-6 py-5">
                                        <span class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-bold">
                                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <a href="{{ route('admin.setoran.create', $siswa->nis) }}"
                                           class="inline-block bg-[#2F7D55] text-white px-5 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold">
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

            <div class="text-center py-16 bg-[#FAFCFB] rounded-[2rem] border border-dashed border-gray-200">
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
