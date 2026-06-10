@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    {{-- HERO HEADER --}}
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F6B4A] via-[#2F7D55] to-[#4D9A72] p-8 shadow-sm">

        <div class="absolute -right-20 -top-20 w-72 h-72 rounded-full bg-white/10"></div>
        <div class="absolute -left-16 -bottom-20 w-52 h-52 rounded-full bg-white/10"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <p class="inline-flex items-center bg-white/15 text-white text-xs tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-5">
                    RIWAYAT SETORAN
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    Riwayat Setoran Quran
                </h1>

                <p class="text-white/90 mt-3 max-w-2xl">
                    Data setoran Tahfidz, Murajaah, dan Tilawah yang sudah diinputkan oleh guru.
                </p>
            </div>

            <a href="{{ route('setoran.index') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-6 py-3 rounded-2xl font-bold transition shadow-sm">
                Kembali
            </a>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Riwayat
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas, tanggal, atau jenis setoran untuk melihat data tertentu.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('setoran.riwayat') }}"
                  class="grid grid-cols-1 md:grid-cols-5 gap-4 w-full lg:max-w-6xl">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Kelas
                    </label>

                    <select name="kelas_id"
                            class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                        <option value="">Semua Kelas</option>

                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" {{ (string) request('kelas_id') === (string) $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
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
                           value="{{ request('tanggal') }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Jenis
                    </label>

                    <select name="jenis"
                            class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        <option value="tahfidz" {{ request('jenis') == 'tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                        <option value="murajaah" {{ request('jenis') == 'murajaah' ? 'selected' : '' }}>Murajaah</option>
                        <option value="tilawah" {{ request('jenis') == 'tilawah' ? 'selected' : '' }}>Tilawah</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-4 rounded-2xl font-semibold transition shadow-sm">
                        Filter
                    </button>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('setoran.riwayat') }}"
                       class="w-full text-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold transition">
                        Reset
                    </a>
                </div>

            </form>

        </div>

        @if(request('kelas_id') || request('tanggal') || request('jenis'))
            <div class="mt-6 bg-[#F6FAF8] border border-[#E6F4EC] rounded-2xl px-5 py-4">

                <p class="text-sm text-[#2F7D55] font-semibold">
                    Filter aktif:

                    @if(request('tanggal'))
                        Tanggal {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}
                    @endif

                    @if(request('jenis'))
                        {{ request('tanggal') ? '•' : '' }}
                        Jenis {{ ucfirst(request('jenis')) }}
                    @endif

                    @if(request('kelas_id'))
                        {{ request('tanggal') || request('jenis') ? '•' : '' }}
                        Kelas dipilih
                    @endif
                </p>

            </div>
        @endif

    </div>

    {{-- RIWAYAT SETORAN --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Data Riwayat Setoran
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Daftar setoran Quran yang sudah tersimpan.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $riwayat->count() ?? 0 }} Data
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px]">

                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">NIS</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 text-left font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left font-semibold">Jenis</th>
                        <th class="px-6 py-4 text-left font-semibold">Surah</th>
                        <th class="px-6 py-4 text-left font-semibold">Juz</th>
                        <th class="px-6 py-4 text-left font-semibold">Nilai</th>
                        <th class="px-6 py-4 text-left font-semibold">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($riwayat as $item)

                        @php
                            $jenis = strtolower($item->jenis ?? '');

                            $jenisClass = 'bg-gray-100 text-gray-700 border-gray-200';

                            if ($jenis == 'tahfidz') {
                                $jenisClass = 'bg-green-50 text-green-700 border-green-100';
                            } elseif ($jenis == 'tilawah') {
                                $jenisClass = 'bg-blue-50 text-blue-700 border-blue-100';
                            } elseif ($jenis == 'murajaah') {
                                $jenisClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                            }

                            $nilai = (int) ($item->nilai ?? 0);

                            $nilaiClass = 'bg-red-50 text-red-700 border-red-100';

                            if ($nilai >= 80) {
                                $nilaiClass = 'bg-[#EEF7F1] text-[#2F7D55] border-[#DDF3E7]';
                            } elseif ($nilai >= 60) {
                                $nilaiClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                            }
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition">

                            <td class="px-6 py-5 text-gray-500 whitespace-nowrap">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-5 font-semibold text-[#1F252D] whitespace-nowrap">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-700 whitespace-nowrap">
                                {{ $item->siswa->nis ?? '-' }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold shrink-0">
                                        {{ strtoupper(substr($item->siswa->nama ?? '-', 0, 1)) }}
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-[#1F252D]">
                                            {{ $item->siswa->nama ?? '-' }}
                                        </h4>

                                        <p class="text-sm text-gray-400">
                                            Siswa
                                        </p>
                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-5 text-gray-600 whitespace-nowrap">
                                {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex min-w-[95px] items-center justify-center px-4 py-2 rounded-2xl border text-sm font-semibold {{ $jenisClass }}">
                                    {{ ucfirst($item->jenis ?? '-') }}
                                </span>
                            </td>

                            <td class="px-6 py-5 font-semibold text-gray-800">
                                {{ $item->surah ?? '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-700 whitespace-nowrap">
                                Juz {{ $item->juz ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-4 py-2 rounded-2xl border text-sm font-bold {{ $nilaiClass }}">
                                    {{ $item->nilai ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-gray-600 min-w-[240px]">
                                {{ $item->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="py-14">

                                <div class="text-center">

                                    <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                                        0
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-700">
                                        Belum ada data setoran
                                    </h3>

                                    <p class="text-gray-500 mt-2">
                                        Data setoran Quran akan muncul setelah guru menginput setoran siswa.
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

@endsection
