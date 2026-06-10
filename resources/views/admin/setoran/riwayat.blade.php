@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

        <!-- HERO HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    RIWAYAT SETORAN QURAN
                </div>

                <h1 class="text-4xl font-bold">
                    Riwayat Setoran Quran
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Lihat semua riwayat setoran Quran siswa dari seluruh kelas.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Halaman Aktif
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    Riwayat
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Data setoran siswa
                </p>

                <a href="{{ route('admin.setoran.index') }}"
                class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                    Kembali
                </a>
            </div>

        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <form method="GET"
              action="{{ route('admin.setoran.riwayat') }}"
              class="grid grid-cols-1 md:grid-cols-5 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

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

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Siswa
                </label>

                <select name="siswa_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <option value="">
                        Semua Siswa
                    </option>

                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }} - {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Jenis
                </label>

                <select name="jenis"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option value="tilawah" {{ request('jenis') == 'tilawah' ? 'selected' : '' }}>
                        Tilawah
                    </option>

                    <option value="tahfidz" {{ request('jenis') == 'tahfidz' ? 'selected' : '' }}>
                        Tahfidz
                    </option>

                    <option value="murajaah" {{ request('jenis') == 'murajaah' ? 'selected' : '' }}>
                        Murajaah
                    </option>

                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F7D55] text-white px-6 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Filter
                </button>
            </div>

        </form>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Data Riwayat
                </h2>

                <p class="text-gray-500 mt-1">
                    Total {{ $setorans->count() }} data setoran.
                </p>
            </div>

            <a href="{{ route('admin.setoran.riwayat') }}"
               class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl hover:bg-[#DDF3E7] transition font-bold">
                Reset
            </a>
        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

            <table class="w-full min-w-[1100px]">

                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left">
                            Siswa
                        </th>

                        <th class="px-6 py-4 text-left">
                            Kelas
                        </th>

                        <th class="px-6 py-4 text-left">
                            Surah
                        </th>

                        <th class="px-6 py-4 text-left">
                            Juz
                        </th>

                        <th class="px-6 py-4 text-left">
                            Jenis
                        </th>

                        <th class="px-6 py-4 text-left">
                            Nilai
                        </th>

                        <th class="px-6 py-4 text-left">
                            Keterangan
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($setorans as $index => $item)

                        <tr class="hover:bg-[#FAFCFB] transition">

                            <td class="px-6 py-5">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                            </td>

                            <td class="px-6 py-5 font-semibold text-[#1F252D]">
                                {{ $item->siswa->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $item->surah }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $item->juz }}
                            </td>

                            <td class="px-6 py-5">
                                <span class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl font-bold text-sm">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>

                            <td class="px-6 py-5 font-bold text-[#2F7D55]">
                                {{ $item->nilai }}
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $item->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center py-12 text-gray-500">
                                Belum ada data setoran.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
