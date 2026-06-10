@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

<!-- HEADER -->
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

    <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
    <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                KELOLA KELAS
            </div>

            <h1 class="text-4xl font-bold">
                Data Kelas
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                Kelola daftar kelas, jumlah siswa, dan guru yang memiliki akses ke kelas.
            </p>
        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Total Kelas
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ $kelas->count() }}
            </h2>

            <p class="text-white/80 text-sm mt-1">
                Kelas terdaftar
            </p>

            <p class="text-white/60 text-xs mt-1">
                Data kelas aktif di sistem
            </p>
        </div>

    </div>

</div>
    <!-- FORM TAMBAH KELAS -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Tambah Kelas
            </h2>

            <p class="text-gray-500 mt-1">
                Tambahkan nama kelas baru, misalnya 1A, 1B, 2A, dan seterusnya.
            </p>
        </div>

        <form method="POST"
              action="{{ url('/admin/kelas') }}"
              class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kelas
                    </label>

                    <input type="text"
                           name="nama_kelas"
                           value="{{ old('nama_kelas') }}"
                           placeholder="Contoh: 1A"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-[#2F7D55] text-white px-8 py-4 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Simpan Kelas
                </button>
            </div>

        </form>

    </div>

    <!-- DATA KELAS -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Data Kelas
                </h2>

                <p class="text-gray-500 mt-1">
                    Daftar kelas, jumlah siswa, dan guru yang memiliki akses ke kelas tersebut.
                </p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 md:items-center">

                <input type="text"
                       id="searchKelas"
                       placeholder="Cari kelas atau guru..."
                       class="px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72] min-w-[260px]">

                <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                    <span id="jumlahKelasTampil">{{ $kelas->count() }}</span> kelas
                </div>

            </div>

        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

            <table class="w-full min-w-[1000px]">

                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Kelas</th>
                        <th class="px-6 py-4 text-left font-semibold">Jumlah Siswa</th>
                        <th class="px-6 py-4 text-left font-semibold">Wali Kelas</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($kelas as $index => $item)

                        @php
                            $daftarSiswa = $item->siswas->map(function ($siswa) {
                                return [
                                    'nis' => $siswa->nis,
                                    'nama' => $siswa->nama,
                                ];
                            })->values();

                            $guruText = $item->guruPengampu->pluck('name')->implode(', ');
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition kelas-row"
                            data-search="{{ strtolower($item->nama_kelas . ' ' . $guruText) }}">

                            <td class="px-6 py-5 text-gray-700 no-kelas-cell">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($item->nama_kelas, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-[#1F252D]">
                                            {{ $item->nama_kelas }}
                                        </h4>

                                        <p class="text-sm text-gray-400">
                                            Kelas aktif
                                        </p>
                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-5">

                                <button type="button"
                                        class="btn-detail-siswa bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-bold hover:bg-[#DDF3E7] transition"
                                        data-kelas="{{ $item->nama_kelas }}"
                                        data-siswa='@json($daftarSiswa)'>

                                    {{ $item->siswas_count ?? $item->siswas->count() }} siswa

                                </button>

                            </td>

                            <td class="px-6 py-5">

                                @if($item->guruPengampu->count() > 0)

                                    <div class="flex flex-wrap gap-2">
                                        @foreach($item->guruPengampu as $guru)
                                            <span class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                                {{ $guru->name }}
                                            </span>
                                        @endforeach
                                    </div>

                                @else

                                    <span class="text-gray-400">
                                        Belum ada guru
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-center">

                                <div class="flex items-center justify-center gap-2">

                                    <button type="button"
                                            onclick="openEditKelasModal('editKelasModal{{ $item->id }}')"
                                            class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl hover:bg-yellow-200 transition font-bold">
                                        Edit
                                    </button>

                                    <form method="POST"
                                          action="{{ url('/admin/kelas/' . $item->id) }}"
                                          class="delete-kelas-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-100 text-red-700 px-4 py-2 rounded-xl hover:bg-red-200 transition font-bold">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        <!-- MODAL EDIT KELAS -->
                        <div id="editKelasModal{{ $item->id }}"
                             class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">

                            <div class="bg-white w-full max-w-md rounded-[2rem] shadow-xl p-8">

                                <div class="flex items-center justify-between mb-6">

                                    <div>
                                        <h2 class="text-2xl font-bold text-[#1F252D]">
                                            Edit Kelas
                                        </h2>

                                        <p class="text-gray-500 mt-1">
                                            Ubah nama kelas.
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="closeEditKelasModal('editKelasModal{{ $item->id }}')"
                                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold">
                                        ×
                                    </button>

                                </div>

                                <form method="POST"
                                      action="{{ url('/admin/kelas/' . $item->id) }}"
                                      class="space-y-5">

                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama Kelas
                                        </label>

                                        <input type="text"
                                               name="nama_kelas"
                                               value="{{ $item->nama_kelas }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                               required>
                                    </div>

                                    <div class="flex justify-end gap-3 pt-4">

                                        <button type="button"
                                                onclick="closeEditKelasModal('editKelasModal{{ $item->id }}')"
                                                class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold">
                                            Batal
                                        </button>

                                        <button type="submit"
                                                class="px-6 py-3 rounded-2xl bg-[#2F7D55] text-white hover:bg-[#256B47] transition font-bold">
                                            Simpan
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-500">
                                Belum ada data kelas.
                            </td>
                        </tr>

                    @endforelse

                    <tr id="emptyKelasRow" class="hidden">
                        <td colspan="5" class="text-center py-12 text-gray-500">
                            Tidak ada kelas yang sesuai pencarian.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    const searchKelas = document.getElementById('searchKelas');
    const kelasRows = document.querySelectorAll('.kelas-row');
    const jumlahKelasTampil = document.getElementById('jumlahKelasTampil');
    const emptyKelasRow = document.getElementById('emptyKelasRow');

    function filterKelas() {
        const keyword = searchKelas.value.toLowerCase();
        let totalTampil = 0;

        kelasRows.forEach(function(row) {
            const searchText = row.dataset.search || '';

            if (searchText.includes(keyword)) {
                row.style.display = '';
                totalTampil++;

                const noCell = row.querySelector('.no-kelas-cell');
                if (noCell) {
                    noCell.textContent = totalTampil;
                }
            } else {
                row.style.display = 'none';
            }
        });

        jumlahKelasTampil.textContent = totalTampil;

        if (emptyKelasRow) {
            if (totalTampil === 0 && kelasRows.length > 0) {
                emptyKelasRow.classList.remove('hidden');
            } else {
                emptyKelasRow.classList.add('hidden');
            }
        }
    }

    if (searchKelas) {
        searchKelas.addEventListener('keyup', filterKelas);
        filterKelas();
    }

    function openEditKelasModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditKelasModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelectorAll('.btn-detail-siswa').forEach(function(button) {
        button.addEventListener('click', function() {
            const namaKelas = this.dataset.kelas;
            const siswa = JSON.parse(this.dataset.siswa || '[]');

            let htmlContent = '';

            if (siswa.length === 0) {
                htmlContent = `
                    <div style="text-align:center; color:#6b7280; padding:12px;">
                        Belum ada siswa di kelas ini.
                    </div>
                `;
            } else {
                htmlContent = `
                    <div style="text-align:left;">
                        <table style="width:100%; border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">No</th>
                                    <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">NIS</th>
                                    <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                siswa.forEach(function(item, index) {
                    htmlContent += `
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #f3f4f6;">${index + 1}</td>
                            <td style="padding:10px; border-bottom:1px solid #f3f4f6;">${item.nis ?? '-'}</td>
                            <td style="padding:10px; border-bottom:1px solid #f3f4f6;">${item.nama ?? '-'}</td>
                        </tr>
                    `;
                });

                htmlContent += `
                            </tbody>
                        </table>
                    </div>
                `;
            }

            Swal.fire({
                title: 'Daftar Siswa Kelas ' + namaKelas,
                html: htmlContent,
                width: 650,
                icon: 'info',
                confirmButtonColor: '#2F7D55',
                confirmButtonText: 'Tutup'
            });
        });
    });

    document.querySelectorAll('.delete-kelas-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Kelas?',
                text: 'Kelas yang dihapus tidak bisa digunakan lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
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
