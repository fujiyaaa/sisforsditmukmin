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
                    ADMIN SETORAN QURAN
                </div>

                <h1 class="text-4xl font-bold">
                    Data Siswa Monitoring Quran
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Admin dapat melihat semua kelas dan menginput setoran Quran untuk seluruh siswa.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Total Siswa
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ collect($siswas)->flatten(1)->count() }} Siswa
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Monitoring Setoran Quran
                </p>

                <a href="{{ route('admin.setoran.riwayat') }}"
                   class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                    Riwayat Setoran
                </a>
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
                    Filter Kelas
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas untuk menampilkan siswa tertentu.
                </p>
            </div>

            <a href="{{ route('admin.setoran.index') }}"
               class="bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl hover:bg-gray-200 transition text-center font-semibold">
                Reset Filter
            </a>

        </div>

        <form method="GET"
              action="{{ route('admin.setoran.index') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div class="md:col-span-2">
                <label class="block mb-2 font-semibold text-gray-700">
                    Pilih Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">

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
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition font-semibold">
                    Tampilkan
                </button>
            </div>

            <div class="flex items-end">
                <div class="w-full bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold text-center">
                    {{ collect($siswas)->flatten(1)->count() }} Siswa
                </div>
            </div>

        </form>

        <div class="mt-6 bg-[#EEF7F1] border border-gray-100 rounded-2xl p-5">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                <div>
                    <p class="font-bold text-[#2F7D55]">
                        Setoran Quran
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Pilih siswa untuk menginput setoran Tahfidz, Murajaah, atau Tilawah.
                    </p>
                </div>

                <div class="bg-white text-[#2F7D55] px-4 py-2 rounded-2xl font-bold text-sm tracking-wide">
                    QURAN
                </div>

            </div>

        </div>

    </div>

    {{-- TABLE SISWA --}}
    <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih siswa untuk menginput setoran Quran.
                </p>
            </div>

            <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ collect($siswas)->flatten(1)->count() }} siswa
            </div>

        </div>

        @if ($siswas->count() > 0)

            <div class="overflow-x-auto rounded-3xl border border-gray-100">

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
                                <td colspan="5" class="bg-[#F8FBF9] px-6 py-4 font-bold text-[#1F252D] border-b border-gray-100">
                                    Kelas {{ $kelasNama }}
                                </td>
                            </tr>

                            @foreach ($dataSiswa as $siswa)

                                <tr class="hover:bg-[#F8FBF9] transition">

                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $no++ }}
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
                                        <span class="inline-flex items-center bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-semibold">
                                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <a href="{{ route('admin.setoran.create', $siswa->nis) }}"
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