@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    <div class="bg-white rounded-3xl shadow-lg p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#2F6F4F]">
                    Riwayat Setoran Quran
                </h1>

                <p class="text-gray-500 mt-2">
                    Data setoran hafalan, murajaah, dan tilawah yang sudah diinputkan oleh guru.
                </p>
            </div>

            <a href="{{ route('setoran.index') }}"
               class="bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl hover:bg-gray-200 transition text-center">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form method="GET" action="{{ route('setoran.riwayat') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <select name="kelas_id"
                    class="border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#4D9A72]">
                <option value="">Semua Kelas</option>

                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}" {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <input type="date"
                   name="tanggal"
                   value="{{ request('tanggal') }}"
                   class="border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#4D9A72]">

            <select name="jenis"
                    class="border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#4D9A72]">
                <option value="">Semua Jenis</option>
                <option value="tahfidz" {{ request('jenis') == 'tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                <option value="murajaah" {{ request('jenis') == 'murajaah' ? 'selected' : '' }}>Murajaah</option>
                <option value="tilawah" {{ request('jenis') == 'tilawah' ? 'selected' : '' }}>Tilawah</option>
            </select>

            <button type="submit"
                    class="bg-[#4D9A72] text-white px-5 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                Filter
            </button>

        </form>

        <div class="overflow-x-auto rounded-2xl border border-gray-100">
            <table class="w-full">
                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">NIS</th>
                        <th class="px-6 py-4 text-left">Nama Siswa</th>
                        <th class="px-6 py-4 text-left">Kelas</th>
                        <th class="px-6 py-4 text-left">Jenis</th>
                        <th class="px-6 py-4 text-left">Surah</th>
                        <th class="px-6 py-4 text-left">Juz</th>
                        <th class="px-6 py-4 text-left">Nilai</th>
                        <th class="px-6 py-4 text-left">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($riwayat as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->siswa->nis ?? '-' }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $item->siswa->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700 font-semibold">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->surah }}
                            </td>

                            <td class="px-6 py-4">
                                Juz {{ $item->juz }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->nilai ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data setoran yang diinputkan oleh guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
