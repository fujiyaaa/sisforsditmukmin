@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1F6B4A]">
                Laporan Prestasi & Pelanggaran
            </h1>

            <p class="text-gray-500 mt-2">
                Admin dapat memilih siswa untuk menginput laporan prestasi, pelanggaran, atau informasi.
            </p>
        </div>

        <div class="bg-[#EEF7F1] px-6 py-4 rounded-2xl">
            <p class="text-sm text-gray-500">Hari Ini</p>
            <h2 class="text-xl font-bold text-[#2F7D55] mt-1">
                {{ now()->format('d M Y') }}
            </h2>
        </div>
    </div>

    <!-- FILTER KELAS -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Pilih Kelas
        </h2>

        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    <option value="">-- Semua Kelas --</option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas ?? $item->kelas ?? 'Kelas' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#3F8260] transition">
                    Tampilkan Siswa
                </button>
            </div>

            <div class="flex items-end">
                <a href="{{ route('admin.laporan.index') }}"
                   class="w-full text-center border border-gray-300 text-gray-600 px-6 py-3 rounded-xl hover:bg-gray-100 transition">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <!-- DAFTAR SISWA -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Daftar Siswa
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-4 py-3 text-left rounded-l-xl">No</th>
                        <th class="px-4 py-3 text-left">NIS</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswas as $siswa)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $siswa->nis }}
                            </td>

                            <td class="px-4 py-4 font-semibold">
                                {{ $siswa->nama }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('admin.laporan.create', $siswa->nis) }}"
                                   class="inline-block bg-[#4D9A72] text-white px-4 py-2 rounded-xl hover:bg-[#3F8260] transition">
                                    Tulis Laporan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- RIWAYAT LAPORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Riwayat Laporan
        </h2>

        <div class="space-y-4">

            @forelse ($laporans as $laporan)

                <div class="border rounded-2xl p-5 bg-[#F8FBF9]">

                    <div class="flex justify-between items-start gap-4">

                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                {{ $laporan->jenis == 'prestasi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $laporan->jenis == 'pelanggaran' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $laporan->jenis == 'informasi' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ ucfirst($laporan->jenis) }}
                            </span>

                            <h3 class="text-lg font-bold text-gray-800 mt-3">
                                {{ $laporan->judul }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $laporan->siswa->nama ?? '-' }}
                                |
                                {{ $laporan->siswa->kelas->nama_kelas ?? $laporan->siswa->kelas ?? '-' }}
                                |
                                {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="text-sm text-gray-400">
                            {{ $laporan->created_at->format('d M Y') }}
                        </div>

                    </div>

                    <p class="text-gray-600 mt-4">
                        {{ $laporan->deskripsi }}
                    </p>

                    <p class="text-sm text-gray-500 mt-3">
                        <strong>Detail:</strong> {{ $laporan->tingkat ?? '-' }}
                    </p>

                    @if ($laporan->catatan)
                        <p class="text-sm text-gray-500 mt-2">
                            <strong>Catatan:</strong> {{ $laporan->catatan }}
                        </p>
                    @endif

                </div>

            @empty

                <div class="text-center text-gray-500 py-8">
                    Belum ada riwayat laporan.
                </div>

            @endforelse

        </div>

    </div>

</div>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#4D9A72'
        });
    </script>
@endif

@endsection
