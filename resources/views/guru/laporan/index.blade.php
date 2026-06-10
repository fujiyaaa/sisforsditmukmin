@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    <!-- HERO HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    PANEL GURU
                </div>

                <h1 class="text-4xl font-bold">
                    Laporan Prestasi & Pelanggaran
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Kelola laporan siswa dengan lebih cepat. Pilih kelas, lihat riwayat laporan, lalu tulis laporan baru untuk siswa yang dipilih.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Total Siswa Ditampilkan
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $siswas->count() ?? 0 }}
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Siswa aktif
                </p>

                <p class="text-white/60 text-xs mt-1">
                    {{ now()->translatedFormat('l, d M Y') }}
                </p>
            </div>

        </div>

    </div>

    {{-- FILTER KELAS --}}
    <div class="bg-white rounded-[28px] shadow-lg border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#1F2937]">
                    Pilih Kelas & Siswa
                </h2>
                <p class="text-gray-500 mt-1">
                    Pilih kelas untuk menampilkan daftar siswa.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-semibold text-sm">
                {{ $kelas->count() }} kelas tersedia
            </div>
        </div>

        <form method="GET"
              action="{{ route('laporan.index') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="md:col-span-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-[#4D9A72]">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas ?? $item->kelas ?? 'Kelas' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Cari Siswa
                </label>

                <input type="text"
                       id="searchSiswa"
                       placeholder="Cari nama atau NIS siswa..."
                       class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-[#4D9A72]">
            </div>

            <div class="md:col-span-1 flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3.5 rounded-2xl font-semibold hover:bg-[#3E845F] transition shadow-sm">
                    Tampilkan Siswa
                </button>
            </div>
        </form>
    </div>

    {{-- DAFTAR SISWA --}}
    <div class="bg-white rounded-[28px] shadow-lg border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#1F2937]">
                    Daftar Siswa
                </h2>
                <p class="text-gray-500 mt-1">
                    Klik <span class="font-semibold text-[#2F7D55]">View Laporan</span> untuk melihat riwayat laporan siswa.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] font-semibold text-sm">
                {{ $siswas->count() }} siswa
            </div>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-gray-100">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="px-5 py-4 text-left rounded-tl-2xl">No</th>
                        <th class="px-5 py-4 text-left">Siswa</th>
                        <th class="px-5 py-4 text-left">Kelas</th>
                        <th class="px-5 py-4 text-center">Riwayat</th>
                        <th class="px-5 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>

                <tbody id="siswaTableBody">
                    @forelse ($siswas as $siswa)

                        @php
                            $dataLaporanSiswa = $laporanSiswa[$siswa->id] ?? collect();
                            $inisial = strtoupper(substr($siswa->nama, 0, 1));
                        @endphp

                        <tr class="border-b border-gray-100 hover:bg-[#FAFCFB] transition siswa-row"
                            data-nama="{{ strtolower($siswa->nama) }}"
                            data-nis="{{ strtolower($siswa->nis) }}">

                            <td class="px-5 py-4 text-gray-700 font-medium">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-[#DDEFE4] text-[#2F7D55] font-bold flex items-center justify-center">
                                        {{ $inisial }}
                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-800">
                                            {{ $siswa->nama }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            NIS: {{ $siswa->nis }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-[#EEF7F1] text-[#2F7D55] font-semibold text-sm">
                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <button type="button"
                                        onclick="openModalLaporan({{ $siswa->id }})"
                                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-sm">
                                    View Laporan
                                </button>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('laporan.create', $siswa->nis) }}"
                                   class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#4D9A72] text-white font-semibold hover:bg-[#3E845F] transition shadow-sm">
                                    Tulis Laporan
                                </a>
                            </td>
                        </tr>

                        {{-- MODAL RIWAYAT LAPORAN --}}
                        <div id="modal-laporan-{{ $siswa->id }}"
                             class="hidden fixed inset-0 bg-black/50 backdrop-blur-[2px] z-50 items-center justify-center px-4 py-8">

                            <div class="bg-white w-full max-w-5xl rounded-[30px] shadow-2xl relative max-h-[90vh] overflow-y-auto">
                                <div class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-gray-100 px-8 py-6 rounded-t-[30px] z-10">
                                    <button type="button"
                                            onclick="closeModalLaporan({{ $siswa->id }})"
                                            class="absolute top-5 right-6 w-11 h-11 rounded-full bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 text-2xl font-bold transition">
                                        &times;
                                    </button>

                                    <div class="pr-14">
                                        <h2 class="text-3xl font-bold text-[#1F6B4A]">
                                            Riwayat Laporan Siswa
                                        </h2>

                                        <p class="text-gray-500 mt-2">
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
                                </div>

                                <div class="p-8">
                                    @if ($dataLaporanSiswa->count() > 0)
                                        <div class="space-y-5">
                                            @foreach ($dataLaporanSiswa as $laporan)

                                                <div class="laporan-card-{{ $siswa->id }} border border-gray-100 rounded-[24px] p-6 bg-[#FBFDFC] shadow-sm"
                                                     data-jenis="{{ $laporan->jenis }}">

                                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                                        <div>
                                                            <div class="flex flex-wrap items-center gap-2">
                                                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                                                    {{ $laporan->jenis == 'prestasi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                                    {{ $laporan->jenis == 'pelanggaran' ? 'bg-red-100 text-red-700' : '' }}
                                                                    {{ $laporan->jenis == 'informasi' ? 'bg-blue-100 text-blue-700' : '' }}">
                                                                    {{ ucfirst($laporan->jenis) }}
                                                                </span>
                                                            </div>

                                                            <h3 class="text-2xl font-bold text-gray-800 mt-4">
                                                                {{ $laporan->judul }}
                                                            </h3>

                                                            <p class="text-sm text-gray-500 mt-2">
                                                                Tanggal Laporan:
                                                                {{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') : '-' }}
                                                            </p>
                                                        </div>

                                                        <div class="text-sm text-gray-400">
                                                            Diinput:
                                                            {{ $laporan->created_at ? $laporan->created_at->format('d M Y') : '-' }}
                                                        </div>
                                                    </div>

                                                    <div class="mt-5 text-gray-700 leading-relaxed">
                                                        {{ $laporan->deskripsi }}
                                                    </div>

                                                    @if ($laporan->tingkat)
                                                        <p class="text-sm text-gray-600 mt-4">
                                                            <span class="font-semibold">Detail:</span> {{ $laporan->tingkat }}
                                                        </p>
                                                    @endif

                                                    @if ($laporan->jenis == 'prestasi' && $laporan->sertifikat)
                                                        @php
                                                            $fileUrl = asset('storage/' . $laporan->sertifikat);
                                                            $extension = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                                                        @endphp

                                                        <div class="mt-5 bg-white border border-gray-100 rounded-[22px] p-4">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <p class="text-sm font-medium text-gray-500">
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
                                                                         class="w-full max-h-[320px] object-contain rounded-2xl border border-gray-100 bg-gray-50">
                                                                </a>
                                                            @elseif ($extension == 'pdf')
                                                                <a href="{{ $fileUrl }}"
                                                                   target="_blank"
                                                                   class="inline-flex items-center bg-yellow-100 text-yellow-700 px-5 py-3 rounded-xl font-semibold hover:bg-yellow-200 transition">
                                                                    Lihat Lampiran PDF
                                                                </a>
                                                            @else
                                                                <a href="{{ $fileUrl }}"
                                                                   target="_blank"
                                                                   class="inline-flex items-center bg-gray-100 text-gray-700 px-5 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
                                                                    Unduh Lampiran
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if ($laporan->catatan)
                                                        <p class="text-sm text-gray-600 mt-4">
                                                            <span class="font-semibold">Catatan:</span> {{ $laporan->catatan }}
                                                        </p>
                                                    @endif

                                                    <div class="mt-6 flex flex-wrap gap-3 justify-end">
                                                        <a href="{{ route('laporan.edit', $laporan->id) }}"
                                                           class="inline-flex items-center justify-center bg-blue-100 text-blue-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-200 transition">
                                                            Edit
                                                        </a>

                                                        <form method="POST"
                                                              action="{{ route('laporan.destroy', $laporan->id) }}"
                                                              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="bg-red-100 text-red-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-200 transition">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                            @endforeach

                                            <div id="empty-filter-{{ $siswa->id }}" class="hidden text-center py-12">
                                                <h3 class="text-xl font-bold text-gray-700">
                                                    Tidak Ada Laporan
                                                </h3>
                                                <p class="text-gray-500 mt-2">
                                                    Tidak ada laporan sesuai filter yang dipilih.
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-16">
                                            <h3 class="text-xl font-bold text-gray-700">
                                                Belum Ada Laporan
                                            </h3>
                                            <p class="text-gray-500 mt-2">
                                                Siswa ini belum memiliki laporan.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
            document.body.classList.add('overflow-hidden');
            filterLaporanSiswa(id, 'semua');
        }
    }

    function closeModalLaporan(id) {
        const modal = document.getElementById('modal-laporan-' + id);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function filterLaporanSiswa(id, jenis) {
        const cards = document.querySelectorAll('.laporan-card-' + id);
        const emptyMessage = document.getElementById('empty-filter-' + id);
        const buttons = document.querySelectorAll('.filter-btn-' + id);

        let totalTampil = 0;

        cards.forEach(function(card) {
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

        buttons.forEach(function(button) {
            button.classList.remove('bg-[#4D9A72]', 'text-white');
            button.classList.add('bg-gray-100', 'text-gray-700');

            if (button.getAttribute('data-filter') === jenis) {
                button.classList.remove('bg-gray-100', 'text-gray-700');
                button.classList.add('bg-[#4D9A72]', 'text-white');
            }
        });
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id^="modal-laporan-"]');
            modals.forEach(function(modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.classList.remove('overflow-hidden');
        }
    });

    const searchInput = document.getElementById('searchSiswa');
    const siswaRows = document.querySelectorAll('.siswa-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();

            siswaRows.forEach(function(row) {
                const nama = row.getAttribute('data-nama');
                const nis = row.getAttribute('data-nis');

                if (nama.includes(keyword) || nis.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>

@endsection
