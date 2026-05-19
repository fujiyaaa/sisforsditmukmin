@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-3xl font-bold text-[#2F6F4F] mb-2">
            Monitoring Sholat Fardhu
        </h1>

        <p class="text-gray-500">
            Pilih kelas dan tanggal, lalu checklist sholat siswa.
        </p>

    </div>

    <!-- FILTER KELAS DAN TANGGAL -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <form action="{{ route('monitoring-sholat.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Pilih Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <option value="">-- Pilih Kelas --</option>

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
                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                    Tampilkan Siswa
                </button>
            </div>

        </form>

    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- DATA SISWA -->
    @if($kelas_id)

        <form action="{{ route('monitoring-sholat.store') }}" method="POST">
            @csrf

            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="bg-white rounded-2xl shadow-lg p-8">

                <div class="flex justify-between items-center mb-6">

                    <div>
                        <h2 class="text-2xl font-bold text-[#2F6F4F]">
                            Data Checklist Sholat
                        </h2>

                        <p class="text-gray-500 mt-1">
                            Tanggal: {{ $tanggal }}
                        </p>
                    </div>

                    <button type="submit"
                            class="bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                        Simpan Monitoring
                    </button>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-[#4D9A72] text-white">
                                <th class="p-4 text-left rounded-l-xl">NIS</th>
                                <th class="p-4 text-left">Nama Siswa</th>
                                <th class="p-4 text-center">Subuh</th>
                                <th class="p-4 text-center">Dzuhur</th>
                                <th class="p-4 text-center">Ashar</th>
                                <th class="p-4 text-center">Maghrib</th>
                                <th class="p-4 text-center">Isya</th>
                                <th class="p-4 text-left rounded-r-xl">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($siswas as $siswa)

                                @php
                                    $data = $monitoring[$siswa->id] ?? null;
                                @endphp

                                <tr class="border-b hover:bg-gray-50 transition">

                                    <td class="p-4">
                                        {{ $siswa->nis }}
                                    </td>

                                    <td class="p-4 font-medium">
                                        {{ $siswa->nama }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][subuh]"
                                               value="1"
                                               class="w-5 h-5"
                                               {{ $data && $data->subuh ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][dzuhur]"
                                               value="1"
                                               class="w-5 h-5"
                                               {{ $data && $data->dzuhur ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][ashar]"
                                               value="1"
                                               class="w-5 h-5"
                                               {{ $data && $data->ashar ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][maghrib]"
                                               value="1"
                                               class="w-5 h-5"
                                               {{ $data && $data->maghrib ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][isya]"
                                               value="1"
                                               class="w-5 h-5"
                                               {{ $data && $data->isya ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4">
                                        <input type="text"
                                               name="sholat[{{ $siswa->id }}][keterangan]"
                                               value="{{ $data->keterangan ?? '' }}"
                                               placeholder="Opsional"
                                               class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="p-6 text-center text-gray-500">
                                        Belum ada siswa di kelas ini.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </form>

    @endif

</div>

@endsection