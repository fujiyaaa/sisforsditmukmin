@extends('layouts.app')

@section('content')

<div class="bg-white rounded-3xl shadow-md p-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-4xl font-bold text-[#1F252D]">
                Data Siswa Monitoring Quran
            </h1>

            <p class="text-gray-500 mt-2">
                Monitoring hafalan dan ibadah siswa
            </p>

        </div>



    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto rounded-2xl border border-gray-100">

        <table class="w-full">

            <!-- TABLE HEADER -->
            <thead class="bg-[#4D9A72] text-white">

                <tr>

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

            <!-- TABLE BODY -->
            <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($siswas as $siswa)

                <tr class="hover:bg-gray-50 transition">

                    <!-- NIS -->
                    <td class="px-6 py-5 text-gray-700 font-medium">
                        {{ $siswa->nis }}
                    </td>

                    <!-- Nama -->
                    <td class="px-6 py-5">

                        <div class="flex items-center gap-4">

                            <!-- Avatar -->
                            <div class="w-12 h-12 rounded-full bg-[#DDF3E7] flex items-center justify-center text-[#2F7D55] font-bold text-lg">

                                {{ strtoupper(substr($siswa->nama, 0, 1)) }}

                            </div>

                            <!-- Nama -->
                            <div>

                                <h2 class="font-semibold text-[#1F252D]">
                                    {{ $siswa->nama }}
                                </h2>

                                <p class="text-sm text-gray-400">
                                    Siswa Aktif
                                </p>

                            </div>

                        </div>

                    </td>

                    <!-- Kelas -->
                    <td class="px-6 py-5">

                        <span class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-xl text-sm font-semibold">

                            {{ $siswa->kelas }}

                        </span>

                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-5 text-center">

                        <a href="{{ url('/guru/monitoring/' . $siswa->nis) }}"
                           class="bg-[#4D9A72] text-white px-5 py-3 rounded-xl hover:bg-[#3F825F] transition shadow-sm">

                            Input Setoran

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4"
                        class="text-center py-10 text-gray-400">

                        Belum ada data siswa

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection