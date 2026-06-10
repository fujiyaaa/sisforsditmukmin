@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-sm font-semibold text-[#2F7D55] mb-2">
                    Laporan Siswa
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-[#1F252D]">
                    Prestasi & Pelanggaran
                </h1>

                <p class="text-gray-500 mt-3 max-w-2xl">
                    Kelola laporan prestasi, pelanggaran, dan informasi siswa. Data yang diinput admin maupun guru akan tampil untuk orang tua sesuai anaknya.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 min-w-[280px]">
                <div class="bg-[#F6FAF8] border border-[#E4F1EA] rounded-3xl px-5 py-4">
                    <p class="text-sm text-gray-500">
                        Total Siswa
                    </p>

                    <h2 class="text-2xl font-bold text-[#2F7D55] mt-1">
                        {{ $siswas->count() }}
                    </h2>
                </div>

                <div class="bg-[#F6FAF8] border border-[#E4F1EA] rounded-3xl px-5 py-4">
                    <p class="text-sm text-gray-500">
                        Total Laporan
                    </p>

                    <h2 class="text-2xl font-bold text-[#2F7D55] mt-1">
                        {{ $laporans->count() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER KELAS --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Pilih Kelas & Siswa
            </h2>

            <p class="text-gray-500 mt-2">
                Pilih kelas untuk menampilkan daftar siswa yang akan dibuatkan laporan.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.laporan.index') }}">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kelas
                    </label>

                    <select name="kelas_id"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3.5 bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-[#4D9A72]">
                        <option value="">
                            -- Semua Kelas --
                        </option>

                        @foreach($kelas as $item)
                            <option value="{{ $item->id }}" {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                            class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white font-semibold rounded-2xl px-6 py-3.5 transition">
                        Tampilkan Siswa
                    </button>
                </div>

                <div>
                    <a href="{{ route('admin.laporan.index') }}"
                       class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-2xl px-6 py-3.5 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- DAFTAR SISWA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Siswa
                </h2>

                <p class="text-gray-500 mt-2">
                    Klik View Laporan untuk melihat riwayat per siswa.
                </p>
            </div>

            <div>
                <input type="text"
                       id="searchSiswa"
                       placeholder="Cari NIS atau nama siswa..."
                       class="w-full md:w-[320px] rounded-2xl border border-gray-200 px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>
        </div>

        <div class="overflow-x-auto rounded-[1.5rem] border border-gray-100">
            <table class="w-full min-w-[900px]">
                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">NIS</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-center font-semibold">View</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($siswas as $index => $siswa)
                        @php
                            $laporanPerSiswa = $laporanSiswa[$siswa->id] ?? collect();

                            $laporanJson = $laporanPerSiswa->map(function ($item) {
                                return [
                                    'id' => $item->id,
                                    'jenis' => $item->jenis,
                                    'judul' => $item->judul,
                                    'deskripsi' => $item->deskripsi,
                                    'tanggal' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-',
                                    'catatan' => $item->catatan,
                                    'tingkat' => $item->tingkat,
                                    'sertifikat' => $item->sertifikat,
                                    'edit_url' => route('admin.laporan.edit', $item->id),
                                    'delete_url' => route('admin.laporan.destroy', $item->id),
                                ];
                            })->values();
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition siswa-row"
                            data-search="{{ strtolower($siswa->nis . ' ' . $siswa->nama . ' ' . ($siswa->kelas->nama_kelas ?? '')) }}">

                            <td class="px-6 py-5 text-gray-700 no-siswa-cell">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5 text-gray-700 font-medium">
                                {{ $siswa->nis }}
                            </td>

                            <td class="px-6 py-5">
                                <div>
                                    <h3 class="font-bold text-[#1F252D]">
                                        {{ $siswa->nama }}
                                    </h3>

                                    <p class="text-sm text-gray-400 mt-1">
                                        Siswa Aktif
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-[#EEF7F1] text-[#2F7D55] text-sm font-semibold">
                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <button type="button"
                                        onclick="openLaporanModal(this)"
                                        data-nama="{{ $siswa->nama }}"
                                        data-nis="{{ $siswa->nis }}"
                                        data-kelas="{{ $siswa->kelas->nama_kelas ?? '-' }}"
                                        data-laporan='@json($laporanJson)'
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition">
                                    View Laporan
                                </button>

                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $laporanPerSiswa->count() }} laporan
                                </p>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('admin.laporan.create', $siswa->nis) }}"
                                   class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-5 py-2.5 rounded-xl font-semibold transition">
                                    Tulis Laporan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-10 text-gray-400">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse

                    <tr id="emptySiswaRow" class="hidden">
                        <td colspan="6" class="text-center px-6 py-10 text-gray-400">
                            Siswa tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



{{-- MODAL VIEW LAPORAN --}}
<div id="laporanModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-8">

    <div class="bg-white w-full max-w-4xl rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-7 border-b border-gray-100">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F7D55]">
                        Riwayat Laporan Siswa
                    </h3>

                    <p id="modalStudentInfo" class="text-gray-500 mt-2">
                        -
                    </p>
                </div>

                <button type="button"
                        onclick="closeLaporanModal()"
                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 text-2xl leading-none transition">
                    ×
                </button>
            </div>

            <div class="flex flex-wrap gap-3 mt-6">
                <button type="button" class="modal-chip bg-[#4D9A72] text-white px-4 py-2 rounded-xl font-semibold text-sm" data-filter="semua">
                    Semua
                </button>

                <button type="button" class="modal-chip bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm" data-filter="prestasi">
                    Prestasi
                </button>

                <button type="button" class="modal-chip bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm" data-filter="pelanggaran">
                    Pelanggaran
                </button>

                <button type="button" class="modal-chip bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-semibold text-sm" data-filter="informasi">
                    Informasi
                </button>
            </div>
        </div>

        <div class="p-7 max-h-[70vh] overflow-y-auto">
            <div id="modalLaporanList" class="space-y-5"></div>
        </div>
    </div>
</div>

<script>
    const searchSiswa = document.getElementById('searchSiswa');
    const siswaRows = document.querySelectorAll('.siswa-row');
    const emptySiswaRow = document.getElementById('emptySiswaRow');

    function filterSiswa() {
        if (!searchSiswa) return;

        const keyword = searchSiswa.value.toLowerCase();
        let totalTampil = 0;

        siswaRows.forEach(function(row) {
            const searchText = row.dataset.search || '';

            if (searchText.includes(keyword)) {
                row.style.display = '';
                totalTampil++;

                const noCell = row.querySelector('.no-siswa-cell');
                if (noCell) {
                    noCell.textContent = totalTampil;
                }
            } else {
                row.style.display = 'none';
            }
        });

        if (emptySiswaRow) {
            if (totalTampil === 0 && siswaRows.length > 0) {
                emptySiswaRow.classList.remove('hidden');
            } else {
                emptySiswaRow.classList.add('hidden');
            }
        }
    }

    if (searchSiswa) {
        searchSiswa.addEventListener('keyup', filterSiswa);
    }

    let currentModalData = [];

    function openLaporanModal(button) {
        const nama = button.dataset.nama;
        const nis = button.dataset.nis;
        const kelas = button.dataset.kelas;
        const laporan = JSON.parse(button.dataset.laporan || '[]');

        currentModalData = laporan;

        document.getElementById('modalStudentInfo').innerText = `${nama} | ${nis} | ${kelas}`;
        document.getElementById('laporanModal').classList.remove('hidden');
        document.getElementById('laporanModal').classList.add('flex');

        setActiveChip('semua');
        renderModalLaporan('semua');
    }

    function closeLaporanModal() {
        document.getElementById('laporanModal').classList.add('hidden');
        document.getElementById('laporanModal').classList.remove('flex');
    }

    function setActiveChip(filter) {
        document.querySelectorAll('.modal-chip').forEach(chip => {
            if (chip.dataset.filter === filter) {
                chip.classList.remove('bg-gray-100', 'text-gray-700');
                chip.classList.add('bg-[#4D9A72]', 'text-white');
            } else {
                chip.classList.remove('bg-[#4D9A72]', 'text-white');
                chip.classList.add('bg-gray-100', 'text-gray-700');
            }
        });
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return text
            .toString()
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function renderModalLaporan(filter = 'semua') {
        const container = document.getElementById('modalLaporanList');

        let filtered = currentModalData;

        if (filter !== 'semua') {
            filtered = currentModalData.filter(item => item.jenis === filter);
        }

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="rounded-[1.5rem] border border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center text-gray-400">
                    Tidak ada laporan untuk filter ini.
                </div>
            `;
            return;
        }

        container.innerHTML = filtered.map(item => {
            const jenis = (item.jenis || '').toLowerCase();

            let badgeClass = 'bg-gray-100 text-gray-700';
            let badgeText = 'Informasi';

            if (jenis === 'prestasi') {
                badgeClass = 'bg-yellow-100 text-yellow-700';
                badgeText = 'Prestasi';
            } else if (jenis === 'pelanggaran') {
                badgeClass = 'bg-red-100 text-red-700';
                badgeText = 'Pelanggaran';
            } else if (jenis === 'informasi') {
                badgeClass = 'bg-blue-100 text-blue-700';
                badgeText = 'Informasi';
            }

            let lampiranHtml = '';

            if (item.sertifikat) {
                const ext = item.sertifikat.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png', 'webp'].includes(ext);

                lampiranHtml = `
                    <div class="mt-6 rounded-[1.5rem] border border-gray-200 bg-white p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-500">
                                Lampiran ${escapeHtml(badgeText)}
                            </h4>

                            <a href="/storage/${item.sertifikat}"
                               target="_blank"
                               class="text-[#2F7D55] font-semibold hover:underline">
                                Buka Lampiran
                            </a>
                        </div>

                        <div class="rounded-[1.25rem] border border-gray-100 bg-[#F8FAF9] p-4 flex justify-center">
                            ${
                                isImage
                                    ? `<img src="/storage/${item.sertifikat}" class="max-h-[260px] rounded-2xl object-contain" alt="Lampiran">`
                                    : `<a href="/storage/${item.sertifikat}" target="_blank" class="inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] font-semibold px-5 py-3 rounded-2xl">Lihat File Lampiran</a>`
                            }
                        </div>
                    </div>
                `;
            }

            return `
                <div class="rounded-[1.75rem] border border-gray-200 bg-[#FCFDFC] p-6 shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        <div class="flex-1">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold ${badgeClass}">
                                ${badgeText}
                            </span>

                            <h3 class="text-2xl font-bold text-[#1F252D] mt-4">
                                ${escapeHtml(item.judul)}
                            </h3>

                            <p class="text-gray-500 mt-2">
                                Tanggal Laporan: ${escapeHtml(item.tanggal)}
                            </p>
                        </div>

                        <div class="text-sm text-gray-400">
                            ${escapeHtml(item.tanggal)}
                        </div>
                    </div>

                    <div class="mt-5 space-y-4 text-gray-700">
                        <p>${escapeHtml(item.deskripsi || '-')}</p>

                        ${item.tingkat ? `
                            <p>
                                <span class="font-semibold text-[#1F252D]">Detail:</span>
                                ${escapeHtml(item.tingkat)}
                            </p>
                        ` : ''}
                    </div>

                    ${lampiranHtml}

                    ${item.catatan ? `
                        <div class="mt-5 text-gray-600">
                            <span class="font-semibold text-[#1F252D]">Catatan:</span>
                            ${escapeHtml(item.catatan)}
                        </div>
                    ` : ''}
                    <div class="mt-6 flex flex-wrap gap-3 justify-end">
                        <a href="${item.edit_url}"
                        class="inline-flex items-center justify-center bg-blue-100 text-blue-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-200 transition">
                            Edit
                        </a>

                        <form method="POST"
                            action="${item.delete_url}"
                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">

                            <button type="submit"
                                    class="bg-red-100 text-red-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-200 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            `;
        }).join('');
    }

    document.querySelectorAll('.modal-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            const filter = this.dataset.filter;

            setActiveChip(filter);
            renderModalLaporan(filter);
        });
    });

    document.getElementById('laporanModal').addEventListener('click', function(e) {
        if (e.target.id === 'laporanModal') {
            closeLaporanModal();
        }
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2F7D55',
            confirmButtonText: 'Oke'
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#2F7D55',
            confirmButtonText: 'Oke'
        });
    </script>
@endif

@endsection
