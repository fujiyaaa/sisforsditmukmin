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
                KELOLA GURU
            </div>

            <h1 class="text-4xl font-bold">
                Data Guru
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                Kelola akun guru, nomor telepon, NIP, dan kelas yang diampu.
            </p>
        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Total Guru
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ $guru->count() }}
            </h2>

            <p class="text-white/80 text-sm mt-1">
                Guru terdaftar
            </p>

            <p class="text-white/60 text-xs mt-1">
                Akun guru aktif di sistem
            </p>
        </div>

    </div>

</div>

    <!-- FORM TAMBAH GURU -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Tambah Guru
            </h2>

            <p class="text-gray-500 mt-1">
                Tambahkan data guru dan tentukan kelas yang diampu.
            </p>
        </div>

        <form method="POST"
              action="{{ url('/admin/guru') }}"
              class="space-y-7">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NAMA -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Guru
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama guru"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

                <!-- NIP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        NIP Guru
                    </label>

                    <input type="text"
                           name="nip"
                           value="{{ old('nip') }}"
                           placeholder="Masukkan NIP guru"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>

                    <p class="text-xs text-gray-400 mt-2">
                        NIP digunakan untuk login guru.
                    </p>
                </div>

                <!-- PHONE -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        No. Telepon
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>

                    <input type="text"
                           name="password"
                           value="{{ old('password', 'password123') }}"
                           placeholder="Masukkan password"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>

                    <p class="text-xs text-gray-400 mt-2">
                        Guru wajib mengganti password setelah login.
                    </p>
                </div>

            </div>

            <!-- KELAS DIAMPU -->
            <div class="bg-[#F8FBF9] rounded-[2rem] p-6 border border-gray-100">

                <div class="mb-5">
                    <h3 class="text-lg font-bold text-[#2F7D55]">
                        Kelas yang Diampu
                    </h3>

                    <p class="text-gray-500 text-sm mt-1">
                        Pilih satu atau beberapa kelas yang dapat diakses oleh guru.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">

                    @forelse($kelas as $item)

                        <label class="cursor-pointer">
                            <input type="checkbox"
                                   name="kelas_ids[]"
                                   value="{{ $item->id }}"
                                   class="peer hidden"
                                   {{ is_array(old('kelas_ids')) && in_array($item->id, old('kelas_ids')) ? 'checked' : '' }}>

                            <div class="px-4 py-3 rounded-2xl border border-gray-200 bg-white text-gray-600 text-center font-bold transition peer-checked:bg-[#2F7D55] peer-checked:text-white peer-checked:border-[#2F7D55] hover:border-[#4D9A72]">
                                {{ $item->nama_kelas }}
                            </div>
                        </label>

                    @empty

                        <div class="col-span-full text-gray-500 text-sm">
                            Belum ada data kelas.
                        </div>

                    @endforelse

                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-[#2F7D55] text-white px-8 py-4 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Simpan Guru
                </button>
            </div>

        </form>

    </div>

    <!-- DATA GURU -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Data Guru
                </h2>

                <p class="text-gray-500 mt-1">
                    Daftar guru beserta kontak dan kelas yang diampu.
                </p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 md:items-center">

                <input type="text"
                       id="searchGuru"
                       placeholder="Cari nama, NIP, telepon..."
                       class="px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72] min-w-[260px]">

                <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                    <span id="jumlahGuruTampil">{{ $guru->count() }}</span> guru
                </div>

            </div>

        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

            <table class="w-full min-w-[1100px]">

                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Guru</th>
                        <th class="px-6 py-4 text-left font-semibold">NIP</th>
                        <th class="px-6 py-4 text-left font-semibold">No. Telepon</th>
                        <th class="px-6 py-4 text-left font-semibold">Kelas Diampu</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($guru as $index => $guru)

                        @php
                            $kelasDiampuText = $guru->kelasDiampu->pluck('nama_kelas')->implode(', ');
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition guru-row"
                            data-search="{{ strtolower($guru->name . ' ' . ($guru->nip ?? '') . ' ' . ($guru->phone ?? '') . ' ' . $kelasDiampuText) }}">

                            <td class="px-6 py-5 text-gray-700 no-guru-cell">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">

                                    <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($guru->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-[#1F252D]">
                                            {{ $guru->name }}
                                        </h4>

                                        <p class="text-sm text-gray-400">
                                            Akun Guru
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                    {{ $guru->nip ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-5">

                                <button type="button"
                                        class="btn-detail-guru text-left group"
                                        data-nama="{{ $guru->name }}"
                                        data-nip="{{ $guru->nip ?? '-' }}"
                                        data-phone="{{ $guru->phone ?? '-' }}"
                                        data-kelas="{{ $kelasDiampuText ?: '-' }}">

                                    <p class="font-bold text-[#1F252D] group-hover:text-[#2F7D55] transition">
                                        {{ $guru->phone ?? 'Lihat kontak' }}
                                    </p>

                                    <p class="text-sm text-[#2F7D55] font-semibold mt-1">
                                        Lihat detail guru
                                    </p>

                                </button>

                            </td>

                            <td class="px-6 py-5">

                                @if($guru->kelasDiampu->count() > 0)

                                    <div class="flex flex-wrap gap-2">
                                        @foreach($guru->kelasDiampu as $kelasItem)
                                            <span class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-bold">
                                                {{ $kelasItem->nama_kelas }}
                                            </span>
                                        @endforeach
                                    </div>

                                @else

                                    <span class="text-gray-400">
                                        Belum diatur
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5">

                                @if($guru->must_change_password)
                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        Wajib ganti password
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        Aktif
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-5 text-center">

                                <div class="flex items-center justify-center gap-2">

                                    <button type="button"
                                            onclick="openEditModal('editGuruModal{{ $guru->id }}')"
                                            class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl hover:bg-yellow-200 transition font-bold">
                                        Edit
                                    </button>

                                    <form method="POST"
                                          action="{{ url('/admin/guru/' . $guru->id) }}"
                                          class="delete-guru-form">

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

                        <!-- MODAL EDIT GURU -->
                        <div id="editGuruModal{{ $guru->id }}"
                             class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">

                            <div class="bg-white w-full max-w-3xl rounded-[2rem] shadow-xl p-8 max-h-[90vh] overflow-y-auto">

                                <div class="flex items-center justify-between mb-6">

                                    <div>
                                        <h2 class="text-2xl font-bold text-[#1F252D]">
                                            Edit Guru
                                        </h2>

                                        <p class="text-gray-500 mt-1">
                                            Ubah data guru dan kelas yang diampu.
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="closeEditModal('editGuruModal{{ $guru->id }}')"
                                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold">
                                        ×
                                    </button>

                                </div>

                                <form method="POST"
                                      action="{{ url('/admin/guru/' . $guru->id) }}"
                                      class="space-y-6">

                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Nama Guru
                                            </label>

                                            <input type="text"
                                                   name="name"
                                                   value="{{ $guru->name }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                NIP
                                            </label>

                                            <input type="text"
                                                   name="nip"
                                                   value="{{ $guru->nip }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                No. Telepon
                                            </label>

                                            <input type="text"
                                                   name="phone"
                                                   value="{{ $guru->phone }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                    </div>

                                    <div class="bg-[#F8FBF9] rounded-[2rem] p-6 border border-gray-100">

                                        <div class="mb-5">
                                            <h3 class="text-lg font-bold text-[#2F7D55]">
                                                Kelas yang Diampu
                                            </h3>

                                            <p class="text-gray-500 text-sm mt-1">
                                                Centang kelas yang boleh diakses guru ini.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">

                                            @foreach($kelas as $item)

                                                <label class="cursor-pointer">
                                                    <input type="checkbox"
                                                           name="kelas_ids[]"
                                                           value="{{ $item->id }}"
                                                           class="peer hidden"
                                                           {{ $guru->kelasDiampu->pluck('id')->contains($item->id) ? 'checked' : '' }}>

                                                    <div class="px-4 py-3 rounded-2xl border border-gray-200 bg-white text-gray-600 text-center font-bold transition peer-checked:bg-[#2F7D55] peer-checked:text-white peer-checked:border-[#2F7D55] hover:border-[#4D9A72]">
                                                        {{ $item->nama_kelas }}
                                                    </div>
                                                </label>

                                            @endforeach

                                        </div>

                                    </div>

                                    <div class="flex justify-end gap-3 pt-4">

                                        <button type="button"
                                                onclick="closeEditModal('editGuruModal{{ $guru->id }}')"
                                                class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold">
                                            Batal
                                        </button>

                                        <button type="submit"
                                                class="px-6 py-3 rounded-2xl bg-[#2F7D55] text-white hover:bg-[#256B47] transition font-bold">
                                            Simpan Perubahan
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                Belum ada data guru.
                            </td>
                        </tr>

                    @endforelse

                    <tr id="emptyGuruRow" class="hidden">
                        <td colspan="7" class="text-center py-12 text-gray-500">
                            Tidak ada guru yang sesuai pencarian.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    const searchGuru = document.getElementById('searchGuru');
    const guruRows = document.querySelectorAll('.guru-row');
    const jumlahGuruTampil = document.getElementById('jumlahGuruTampil');
    const emptyGuruRow = document.getElementById('emptyGuruRow');

    function filterGuru() {
        const keyword = searchGuru.value.toLowerCase();
        let totalTampil = 0;

        guruRows.forEach(function(row) {
            const searchText = row.dataset.search || '';

            if (searchText.includes(keyword)) {
                row.style.display = '';
                totalTampil++;

                const noCell = row.querySelector('.no-guru-cell');
                if (noCell) {
                    noCell.textContent = totalTampil;
                }
            } else {
                row.style.display = 'none';
            }
        });

        jumlahGuruTampil.textContent = totalTampil;

        if (emptyGuruRow) {
            if (totalTampil === 0 && guruRows.length > 0) {
                emptyGuruRow.classList.remove('hidden');
            } else {
                emptyGuruRow.classList.add('hidden');
            }
        }
    }

    if (searchGuru) {
        searchGuru.addEventListener('keyup', filterGuru);
        filterGuru();
    }

    function openEditModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelectorAll('.btn-detail-guru').forEach(function(button) {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Kontak Guru',
                html: `
                    <div style="text-align:left; line-height:1.8">
                        <p><b>Nama Guru:</b><br>${this.dataset.nama}</p>
                        <p><b>NIP:</b><br>${this.dataset.nip}</p>
                        <p><b>No. Telepon:</b><br>${this.dataset.phone}</p>
                        <p><b>Kelas Diampu:</b><br>${this.dataset.kelas}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#2F7D55',
                confirmButtonText: 'Tutup'
            });
        });
    });

    document.querySelectorAll('.delete-guru-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Guru?',
                text: 'Akun guru yang dihapus tidak bisa digunakan lagi.',
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
