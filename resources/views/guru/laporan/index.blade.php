@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-[#1F6B4A]">
                Laporan Prestasi & Pelanggaran
            </h1>

            <p class="text-gray-500 mt-2">
                Pilih kelas dan siswa untuk menginput laporan prestasi atau pelanggaran.
            </p>
        </div>

        <div class="bg-[#EEF7F1] px-6 py-4 rounded-2xl">
            <p class="text-sm text-gray-500">Hari Ini</p>
            <h2 class="text-xl font-bold text-[#2F7D55] mt-1">
                {{ now()->format('d M Y') }}
            </h2>
        </div>
    </div>

    <!-- FILTER KELAS UNTUK INPUT LAPORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Pilih Kelas & Siswa
        </h2>

        <form method="GET"
              action="{{ route('laporan.index') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

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
                        <th class="px-4 py-3 text-center">View</th>
                        <th class="px-4 py-3 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswas as $siswa)

                        @php
                            $dataLaporanSiswa = $laporanSiswa[$siswa->id] ?? collect();
                        @endphp

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
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                <button type="button"
                                        onclick="openModalLaporan({{ $siswa->id }})"
                                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                                    View Laporan
                                </button>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('laporan.create', $siswa->nis) }}"
                                   class="inline-block bg-[#4D9A72] text-white px-4 py-2 rounded-xl hover:bg-[#3F8260] transition">
                                    Tulis Laporan
                                </a>
                            </td>
                        </tr>

                        <!-- MODAL VIEW LAPORAN SISWA -->
                        <div id="modal-laporan-{{ $siswa->id }}"
                             class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center px-4">

                            <div class="bg-white w-full max-w-4xl rounded-3xl shadow-xl p-8 relative max-h-[85vh] overflow-y-auto">

                                <button type="button"
                                        onclick="closeModalLaporan({{ $siswa->id }})"
                                        class="absolute top-4 right-5 text-gray-500 hover:text-red-500 text-3xl font-bold">
                                    &times;
                                </button>

                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-[#1F6B4A]">
                                        Riwayat Laporan Siswa
                                    </h2>

                                    <p class="text-gray-500 mt-1">
                                        {{ $siswa->nama }} |
                                        {{ $siswa->nis }} |
                                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                                    </p>

                                    @if ($dataLaporanSiswa->count() > 0)
                                        <div class="flex flex-wrap gap-2 mt-5">
                                            <button type="button"
                                                    onclick="filterLaporanSiswa({{ $siswa->id }}, 'semua')"
                                                    class="filter-btn-{{ $siswa->id }} bg-[#4D9A72] text-white px-4 py-2 rounded-xl text-sm font-semibold transition"
                                                    data-filter="semua">
                                                Semua
                                            </button>

                                            <button type="button"
                                                    onclick="filterLaporanSiswa({{ $siswa->id }}, 'prestasi')"
                                                    class="filter-btn-{{ $siswa->id }} bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-yellow-100 hover:text-yellow-700 transition"
                                                    data-filter="prestasi">
                                                Prestasi
                                            </button>

                                            <button type="button"
                                                    onclick="filterLaporanSiswa({{ $siswa->id }}, 'pelanggaran')"
                                                    class="filter-btn-{{ $siswa->id }} bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-100 hover:text-red-700 transition"
                                                    data-filter="pelanggaran">
                                                Pelanggaran
                                            </button>

                                            <button type="button"
                                                    onclick="filterLaporanSiswa({{ $siswa->id }}, 'informasi')"
                                                    class="filter-btn-{{ $siswa->id }} bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-100 hover:text-blue-700 transition"
                                                    data-filter="informasi">
                                                Informasi
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                @if ($dataLaporanSiswa->count() > 0)

                                    <div class="space-y-4">

                                        @foreach ($dataLaporanSiswa as $laporan)

                                            <div class="laporan-card-{{ $siswa->id }} border rounded-2xl p-5 bg-[#F8FBF9]"
                                                 data-jenis="{{ $laporan->jenis }}">

                                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">

                                                    <div>
                                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                                            {{ $laporan->jenis == 'prestasi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                            {{ $laporan->jenis == 'pelanggaran' ? 'bg-red-100 text-red-700' : '' }}
                                                            {{ $laporan->jenis == 'informasi' ? 'bg-blue-100 text-blue-700' : '' }}">

                                                            @if ($laporan->jenis == 'prestasi')
                                                                🏆 Prestasi
                                                            @elseif ($laporan->jenis == 'pelanggaran')
                                                                ⚠️ Pelanggaran
                                                            @else
                                                                ℹ️ Informasi
                                                            @endif
                                                        </span>

                                                        <h3 class="text-lg font-bold text-gray-800 mt-3">
                                                            {{ $laporan->judul }}
                                                        </h3>

                                                        <p class="text-sm text-gray-500 mt-1">
                                                            Tanggal Laporan:
                                                            {{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : '-' }}
                                                        </p>
                                                    </div>

                                                    <div class="text-sm text-gray-400">
                                                        Diinput:
                                                        {{ $laporan->created_at ? $laporan->created_at->format('d M Y') : '-' }}
                                                    </div>

                                                </div>

                                                <p class="text-gray-600 mt-4">
                                                    {{ $laporan->deskripsi }}
                                                </p>

                                                @if ($laporan->tingkat)
                                                    <p class="text-sm text-gray-500 mt-3">
                                                        <strong>Detail:</strong> {{ $laporan->tingkat }}
                                                    </p>
                                                @endif

                                                @if ($laporan->catatan)
                                                    <p class="text-sm text-gray-500 mt-2">
                                                        <strong>Catatan:</strong> {{ $laporan->catatan }}
                                                    </p>
                                                @endif

                                                @if ($laporan->jenis == 'prestasi' && $laporan->sertifikat)
                                                    @php
                                                        $fileUrl = asset('storage/' . $laporan->sertifikat);
                                                        $extension = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                                                    @endphp

                                                    <div class="mt-4 bg-white rounded-2xl p-4 border border-gray-100">

                                                        <div class="flex items-center justify-between mb-3">
                                                            <p class="text-sm text-gray-500">
                                                                Lampiran Prestasi
                                                            </p>

                                                            <a href="{{ $fileUrl }}"
                                                               target="_blank"
                                                               class="text-sm font-semibold text-[#2F7D55] hover:underline">
                                                                Buka Lampiran
                                                            </a>
                                                        </div>

                                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))

                                                            <a href="{{ $fileUrl }}" target="_blank">
                                                                <img src="{{ $fileUrl }}"
                                                                     alt="Lampiran Prestasi"
                                                                     class="w-full max-h-[250px] object-contain rounded-2xl border border-gray-100 bg-gray-50">
                                                            </a>

                                                        @elseif ($extension == 'pdf')

                                                            <a href="{{ $fileUrl }}"
                                                               target="_blank"
                                                               class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-5 py-3 rounded-xl font-semibold hover:bg-yellow-200 transition">
                                                                📄 Lihat Lampiran PDF
                                                            </a>

                                                        @else

                                                            <a href="{{ $fileUrl }}"
                                                               target="_blank"
                                                               class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-5 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                                                                📎 Unduh Lampiran
                                                            </a>

                                                        @endif

                                                    </div>
                                                @endif

                                            </div>

                                        @endforeach

                                        <div id="empty-filter-{{ $siswa->id }}"
                                             class="hidden text-center py-12">
                                            <div class="text-5xl mb-4">
                                                🔍
                                            </div>

                                            <h3 class="text-xl font-bold text-gray-700">
                                                Tidak Ada Laporan
                                            </h3>

                                            <p class="text-gray-500 mt-2">
                                                Tidak ada laporan sesuai filter yang dipilih.
                                            </p>
                                        </div>

                                    </div>

                                @else

                                    <div class="text-center py-12">
                                        <div class="text-5xl mb-4">
                                            📄
                                        </div>

                                        <h3 class="text-xl font-bold text-gray-700">
                                            Belum Ada Laporan
                                        </h3>

                                        <p class="text-gray-500 mt-2">
                                            Siswa ini belum memiliki laporan prestasi, pelanggaran, atau informasi.
                                        </p>
                                    </div>

                                @endif

                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- FILTER RIWAYAT LAPORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="mb-5">
            <h2 class="text-xl font-bold text-[#1F6B4A]">
                Filter Riwayat Laporan
            </h2>

            <p class="text-gray-500 mt-1">
                Gunakan filter untuk menampilkan laporan berdasarkan kelas, siswa, atau jenis laporan.
            </p>
        </div>

        <form id="formFilterRiwayat"
              method="GET"
              action="{{ route('laporan.index') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="filter_kelas_id"
                        onchange="document.getElementById('formFilterRiwayat').submit()"
                        class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    <option value="">Semua Kelas</option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ request('filter_kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas ?? $item->kelas ?? 'Kelas' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Siswa
                </label>

                <select name="filter_siswa_id"
                        onchange="document.getElementById('formFilterRiwayat').submit()"
                        class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    <option value="">Semua Siswa</option>

                    @foreach ($filterSiswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ request('filter_siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }} - {{ $siswa->nis }} | {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Jenis Laporan
                </label>

                <select name="filter_jenis"
                        onchange="document.getElementById('formFilterRiwayat').submit()"
                        class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    <option value="">Semua Jenis</option>

                    <option value="prestasi" {{ request('filter_jenis') == 'prestasi' ? 'selected' : '' }}>
                        Prestasi
                    </option>

                    <option value="pelanggaran" {{ request('filter_jenis') == 'pelanggaran' ? 'selected' : '' }}>
                        Pelanggaran
                    </option>

                    <option value="informasi" {{ request('filter_jenis') == 'informasi' ? 'selected' : '' }}>
                        Informasi
                    </option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#3F8260] transition">
                    Filter
                </button>

                <a href="{{ route('laporan.index') }}"
                   class="w-full text-center bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <!-- RIWAYAT LAPORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Riwayat Laporan
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Menampilkan {{ $laporans->count() }} laporan.
                </p>
            </div>

            @if (request('filter_kelas_id') || request('filter_siswa_id') || request('filter_jenis'))
                <div class="text-sm text-[#2F7D55] bg-[#EEF7F1] px-4 py-2 rounded-xl font-semibold">
                    Filter sedang aktif
                </div>
            @endif
        </div>

        <div class="space-y-4">

            @forelse ($laporans as $laporan)

                <div class="border rounded-2xl p-5 bg-[#F8FBF9]">

                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">

                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                {{ $laporan->jenis == 'prestasi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $laporan->jenis == 'pelanggaran' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $laporan->jenis == 'informasi' ? 'bg-blue-100 text-blue-700' : '' }}">

                                @if ($laporan->jenis == 'prestasi')
                                    🏆 Prestasi
                                @elseif ($laporan->jenis == 'pelanggaran')
                                    ⚠️ Pelanggaran
                                @else
                                    ℹ️ Informasi
                                @endif
                            </span>

                            <h3 class="text-lg font-bold text-gray-800 mt-3">
                                {{ $laporan->judul }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $laporan->siswa->nama ?? '-' }}
                                |
                                {{ $laporan->siswa->kelas->nama_kelas ?? '-' }}
                                |
                                {{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div class="text-sm text-gray-400">
                            {{ $laporan->created_at ? $laporan->created_at->format('d M Y') : '-' }}
                        </div>

                    </div>

                    <p class="text-gray-600 mt-4">
                        {{ $laporan->deskripsi }}
                    </p>

                    @if ($laporan->tingkat)
                        <p class="text-sm text-gray-500 mt-3">
                            <strong>Detail:</strong> {{ $laporan->tingkat }}
                        </p>
                    @endif

                    @if ($laporan->jenis == 'prestasi' && $laporan->sertifikat)
                        @php
                            $fileUrl = asset('storage/' . $laporan->sertifikat);
                            $extension = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                        @endphp

                        <div class="mt-4 bg-white rounded-2xl p-4 border border-gray-100">

                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm text-gray-500">
                                    Lampiran Prestasi
                                </p>

                                <a href="{{ $fileUrl }}"
                                   target="_blank"
                                   class="text-sm font-semibold text-[#2F7D55] hover:underline">
                                    Buka Lampiran
                                </a>
                            </div>

                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))

                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}"
                                         alt="Lampiran Prestasi"
                                         class="w-full max-h-[280px] object-contain rounded-2xl border border-gray-100 bg-gray-50">
                                </a>

                            @elseif ($extension == 'pdf')

                                <a href="{{ $fileUrl }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-5 py-3 rounded-xl font-semibold hover:bg-yellow-200 transition">
                                    📄 Lihat Lampiran PDF
                                </a>

                            @else

                                <a href="{{ $fileUrl }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-5 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                                    📎 Unduh Lampiran
                                </a>

                            @endif

                        </div>
                    @endif

                    @if ($laporan->catatan)
                        <p class="text-sm text-gray-500 mt-2">
                            <strong>Catatan:</strong> {{ $laporan->catatan }}
                        </p>
                    @endif

                </div>

            @empty

                <div class="text-center text-gray-500 py-8">
                    Belum ada riwayat laporan sesuai filter.
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

<script>
    function openModalLaporan(id) {
        const modal = document.getElementById('modal-laporan-' + id);

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            filterLaporanSiswa(id, 'semua');
        }
    }

    function closeModalLaporan(id) {
        const modal = document.getElementById('modal-laporan-' + id);

        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function filterLaporanSiswa(id, jenis) {
        const cards = document.querySelectorAll('.laporan-card-' + id);
        const emptyMessage = document.getElementById('empty-filter-' + id);
        const buttons = document.querySelectorAll('.filter-btn-' + id);

        let totalTampil = 0;

        cards.forEach(function (card) {
            const jenisLaporan = card.getAttribute('data-jenis');

            if (jenis === 'semua' || jenisLaporan === jenis) {
                card.classList.remove('hidden');
                totalTampil++;
            } else {
                card.classList.add('hidden');
            }
        });

        if (emptyMessage) {
            if (totalTampil === 0) {
                emptyMessage.classList.remove('hidden');
            } else {
                emptyMessage.classList.add('hidden');
            }
        }

        buttons.forEach(function (button) {
            button.classList.remove('bg-[#4D9A72]', 'text-white');
            button.classList.add('bg-gray-100', 'text-gray-700');

            if (button.getAttribute('data-filter') === jenis) {
                button.classList.remove('bg-gray-100', 'text-gray-700');
                button.classList.add('bg-[#4D9A72]', 'text-white');
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id^="modal-laporan-"]');

            modals.forEach(function (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });
</script>

@endsection
