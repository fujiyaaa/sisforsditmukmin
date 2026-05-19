@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-[#2F6F4F]">
                    Riwayat Monitoring Sholat
                </h1>

                <p class="text-gray-500 mt-2">
                    Lihat data monitoring sholat berdasarkan kelas dan tanggal.
                </p>
            </div>

            <a href="{{ route('monitoring-sholat.index') }}"
               class="bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition text-center">
                + Input Monitoring
            </a>

        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form action="{{ route('monitoring-sholat.riwayat') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <option value="">Semua Kelas</option>

                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
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
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition">
                    Filter Riwayat
                </button>
            </div>

        </form>

    </div>

    <!-- DATA RIWAYAT -->
    @forelse($riwayat as $tanggalData => $items)

        <div class="bg-white rounded-3xl shadow-lg p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

                <div>
                    <h2 class="text-2xl font-bold text-[#2F6F4F]">
                        Tanggal {{ \Carbon\Carbon::parse($tanggalData)->format('d-m-Y') }}
                    </h2>

                    <p class="text-gray-500">
                        Total data: {{ $items->count() }} siswa
                    </p>
                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-[#4D9A72] text-white">
                            <th class="p-4 text-left rounded-l-2xl">NIS</th>
                            <th class="p-4 text-left">Nama Siswa</th>
                            <th class="p-4 text-left">Kelas</th>
                            <th class="p-4 text-center">Subuh</th>
                            <th class="p-4 text-center">Dzuhur</th>
                            <th class="p-4 text-center">Ashar</th>
                            <th class="p-4 text-center">Maghrib</th>
                            <th class="p-4 text-center">Isya</th>
                            <th class="p-4 text-left rounded-r-2xl">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($items as $item)

                            <tr class="border-b hover:bg-gray-50 transition">

                                <td class="p-4">
                                    {{ $item->siswa->nis ?? '-' }}
                                </td>

                                <td class="p-4 font-semibold text-gray-800">
                                    {{ $item->siswa->nama ?? '-' }}
                                </td>

                                <td class="p-4">
                                    {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                                </td>

                                <td class="p-4 text-center">
                                    {!! $item->subuh ? '<span class="text-green-600 font-bold">✓</span>' : '<span class="text-red-500 font-bold">×</span>' !!}
                                </td>

                                <td class="p-4 text-center">
                                    {!! $item->dzuhur ? '<span class="text-green-600 font-bold">✓</span>' : '<span class="text-red-500 font-bold">×</span>' !!}
                                </td>

                                <td class="p-4 text-center">
                                    {!! $item->ashar ? '<span class="text-green-600 font-bold">✓</span>' : '<span class="text-red-500 font-bold">×</span>' !!}
                                </td>

                                <td class="p-4 text-center">
                                    {!! $item->maghrib ? '<span class="text-green-600 font-bold">✓</span>' : '<span class="text-red-500 font-bold">×</span>' !!}
                                </td>

                                <td class="p-4 text-center">
                                    {!! $item->isya ? '<span class="text-green-600 font-bold">✓</span>' : '<span class="text-red-500 font-bold">×</span>' !!}
                                </td>

                                <td class="p-4 text-gray-600">
                                    {{ $item->keterangan ?? '-' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-3xl shadow-lg p-10 text-center">

            <div class="text-5xl mb-4">
                🕌
            </div>

            <h2 class="text-2xl font-bold text-gray-700">
                Belum ada data monitoring
            </h2>

            <p class="text-gray-500 mt-2">
                Pilih kelas dan tanggal, atau input monitoring sholat terlebih dahulu.
            </p>

        </div>

    @endforelse

</div>

@endsection