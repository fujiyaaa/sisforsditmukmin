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
                KELOLA SISWA
            </div>

            <h1 class="text-4xl font-bold">
                Data Siswa
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                Tambahkan data siswa lengkap, hubungkan akun orang tua, atau buat akun orang tua baru sekaligus.
            </p>
        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Total Siswa
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ $siswas->count() }}
            </h2>

            <p class="text-white/80 text-sm mt-1">
                Siswa terdaftar
            </p>

            <p class="text-white/60 text-xs mt-1">
                Data siswa aktif di sistem
            </p>
        </div>

    </div>

</div>
    <!-- FORM TAMBAH SISWA -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Tambah Siswa
            </h2>

            <p class="text-gray-500 mt-1">
                Isi data siswa sesuai kebutuhan.
            </p>
        </div>

        <form method="POST"
              action="{{ url('/admin/siswa') }}"
              class="space-y-8">

            @csrf

            <!-- DATA SISWA -->
            <div>
                <h3 class="text-lg font-bold text-[#2F7D55] mb-4">
                    Data Siswa
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            NIS
                        </label>

                        <input type="text"
                               name="nis"
                               value="{{ old('nis') }}"
                               placeholder="Masukkan NIS"
                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Siswa
                        </label>

                        <input type="text"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama siswa"
                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kelamin
                        </label>

                        <select name="jenis_kelamin"
                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                            <option value="">
                                Pilih Jenis Kelamin
                            </option>

                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kelas
                        </label>

                        <select name="kelas_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                required>

                            <option value="">
                                Pilih Kelas
                            </option>

                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tempat Lahir
                        </label>

                        <input type="text"
                               name="tempat_lahir"
                               value="{{ old('tempat_lahir') }}"
                               placeholder="Contoh: Bandung"
                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Lahir
                        </label>

                        <input type="date"
                               name="tanggal_lahir"
                               value="{{ old('tanggal_lahir') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat
                        </label>

                        <textarea name="alamat"
                                  rows="3"
                                  placeholder="Masukkan alamat siswa"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('alamat') }}</textarea>
                    </div>

                </div>
            </div>

            <!-- OPSI ORANG TUA -->
            <div class="bg-[#F8FBF9] rounded-[2rem] p-6 border border-gray-100">

                <div class="mb-5">
                    <h3 class="text-lg font-bold text-[#2F7D55]">
                        Akun Orang Tua
                    </h3>

                    <p class="text-gray-500 text-sm mt-1">
                        Satu akun orang tua hanya bisa terhubung ke satu siswa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">

                        <select name="opsi_orangtua"
                                id="opsi_orangtua"
                                class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                            <option value="tanpa" {{ old('opsi_orangtua', 'tanpa') == 'tanpa' ? 'selected' : '' }}>
                                Tambah Siswa
                            </option>

                            <option value="buat_baru" {{ old('opsi_orangtua') == 'buat_baru' ? 'selected' : '' }}>
                                Tambah Siswa + Buat akun orang tua
                            </option>

                        </select>
                    </div>

                    <div id="buatBaruWrapper" class="hidden md:col-span-2">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Orang Tua
                                </label>

                                <input type="text"
                                       name="nama_orangtua"
                                       value="{{ old('nama_orangtua') }}"
                                       placeholder="Nama orang tua"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    No. Telepon
                                </label>

                                <input type="text"
                                       name="phone_orangtua"
                                       value="{{ old('phone_orangtua') }}"
                                       placeholder="Contoh: 081234567890"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password
                                </label>

                                <input type="text"
                                       name="password_orangtua"
                                       value="{{ old('password_orangtua', 'password123') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                                <p class="text-xs text-gray-400 mt-2">
                                    Orang tua wajib mengganti password setelah login.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-[#2F7D55] text-white px-8 py-4 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Simpan Siswa
                </button>
            </div>

        </form>

    </div>

    <!-- DATA SISWA -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Data Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Daftar siswa beserta kelas dan akun orang tua yang terhubung.
                </p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 md:items-center">

                <select id="filterKelas"
                        class="px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72] min-w-[220px]">

                    <option value="">
                        Semua Kelas
                    </option>

                    @foreach($kelas as $item)
                        <option value="{{ $item->nama_kelas }}">
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach

                </select>

                <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                    <span id="jumlahSiswaTampil">{{ $siswas->count() }}</span> siswa
                </div>

            </div>

        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

            <table class="w-full min-w-[1300px]">

                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">NIS</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left font-semibold">Tempat Lahir</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal Lahir</th>
                        <th class="px-6 py-4 text-left font-semibold">Alamat</th>
                        <th class="px-6 py-4 text-left font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-left font-semibold">Orang Tua</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($siswas as $index => $siswa)

                        <tr class="hover:bg-[#FAFCFB] transition siswa-row"
                            data-kelas="{{ $siswa->kelas->nama_kelas ?? '' }}">

                            <td class="px-6 py-5 text-gray-700 no-cell">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5 text-gray-700 font-medium">
                                {{ $siswa->nis }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">

                                    <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-[#1F252D]">
                                            {{ $siswa->nama }}
                                        </h4>

                                        <p class="text-sm text-gray-400">
                                            Siswa Aktif
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                @if($siswa->jenis_kelamin == 'L')
                                    Laki-laki
                                @elseif($siswa->jenis_kelamin == 'P')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $siswa->tempat_lahir ?? '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-6 py-5 text-gray-600 max-w-[250px]">
                                {{ $siswa->alamat ?? '-' }}
                            </td>

                            <td class="px-6 py-5">
                                <span class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-bold">
                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                @if($siswa->orangtua)

                                    <button type="button"
                                            class="btn-detail-orangtua text-left group"
                                            data-nama="{{ $siswa->orangtua->name }}"
                                            data-phone="{{ $siswa->orangtua->phone ?? '-' }}"
                                            data-siswa="{{ $siswa->nama }}"
                                            data-nis="{{ $siswa->nis }}">

                                        <p class="font-bold text-[#1F252D] group-hover:text-[#2F7D55] transition">
                                            {{ $siswa->orangtua->name }}
                                        </p>

                                        <p class="text-sm text-[#2F7D55] font-semibold mt-1">
                                            {{ $siswa->orangtua->phone ?? 'Lihat kontak' }}
                                        </p>

                                    </button>

                                @else
                                    <span class="text-gray-400">
                                        Belum terhubung
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">

                                <div class="flex items-center justify-center gap-2">

                                    <button type="button"
                                            onclick="openEditModal('editModal{{ $siswa->id }}')"
                                            class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl hover:bg-yellow-200 transition font-bold">
                                        Edit
                                    </button>

                                    <form method="POST"
                                          action="{{ url('/admin/siswa/' . $siswa->id) }}"
                                          class="delete-siswa-form">

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

                        <!-- MODAL EDIT SISWA -->
                        <div id="editModal{{ $siswa->id }}"
                             class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">

                            <div class="bg-white w-full max-w-4xl rounded-[2rem] shadow-xl p-8 max-h-[90vh] overflow-y-auto">

                                <div class="flex items-center justify-between mb-6">

                                    <div>
                                        <h2 class="text-2xl font-bold text-[#1F252D]">
                                            Edit Data Siswa
                                        </h2>

                                        <p class="text-gray-500 mt-1">
                                            Ubah data siswa dan akun orang tua yang terhubung.
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="closeEditModal('editModal{{ $siswa->id }}')"
                                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold">
                                        ×
                                    </button>

                                </div>

                                <form method="POST"
                                      action="{{ url('/admin/siswa/' . $siswa->id) }}"
                                      class="space-y-6">

                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                NIS
                                            </label>

                                            <input type="text"
                                                   name="nis"
                                                   value="{{ $siswa->nis }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Nama Siswa
                                            </label>

                                            <input type="text"
                                                   name="nama"
                                                   value="{{ $siswa->nama }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Jenis Kelamin
                                            </label>

                                            <select name="jenis_kelamin"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                                                <option value="">
                                                    Pilih Jenis Kelamin
                                                </option>

                                                <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                    Laki-laki
                                                </option>

                                                <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                    Perempuan
                                                </option>

                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Kelas
                                            </label>

                                            <select name="kelas_id"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                    required>

                                                <option value="">
                                                    Pilih Kelas
                                                </option>

                                                @foreach($kelas as $item)
                                                    <option value="{{ $item->id }}" {{ $siswa->kelas_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_kelas }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Tempat Lahir
                                            </label>

                                            <input type="text"
                                                   name="tempat_lahir"
                                                   value="{{ $siswa->tempat_lahir }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Tanggal Lahir
                                            </label>

                                            <input type="date"
                                                   name="tanggal_lahir"
                                                   value="{{ $siswa->tanggal_lahir }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Akun Orang Tua
                                            </label>

                                            <select name="orangtua_id"
                                                    class="select-orangtua w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                                                <option value="">
                                                    Belum terhubung
                                                </option>

                                                @php
                                                    $adaOrangtuaYangBisaDipilih = false;
                                                @endphp

                                                @foreach($orangtuasSemua as $orangtua)

                                                    @if(!$orangtua->siswa || $siswa->orangtua_id == $orangtua->id)

                                                        @php
                                                            $adaOrangtuaYangBisaDipilih = true;
                                                        @endphp

                                                        <option value="{{ $orangtua->id }}" {{ $siswa->orangtua_id == $orangtua->id ? 'selected' : '' }}>
                                                            {{ $orangtua->name }} - {{ $orangtua->phone ?? '-' }}
                                                        </option>

                                                    @endif

                                                @endforeach

                                                @if(!$adaOrangtuaYangBisaDipilih)
                                                    <option value="" disabled>
                                                        Tidak ada akun orang tua yang kosong
                                                    </option>
                                                @endif

                                            </select>

                                            <p class="text-sm text-gray-400 mt-2">
                                                Ketik nama orang tua atau nomor telepon agar lebih cepat ditemukan.
                                            </p>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Alamat
                                            </label>

                                            <textarea name="alamat"
                                                      rows="3"
                                                      class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ $siswa->alamat }}</textarea>
                                        </div>

                                    </div>

                                    <div class="flex justify-end gap-3 pt-4">

                                        <button type="button"
                                                onclick="closeEditModal('editModal{{ $siswa->id }}')"
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
                            <td colspan="10" class="text-center py-12 text-gray-500">
                                Belum ada data siswa.
                            </td>
                        </tr>

                    @endforelse

                    <tr id="emptyFilterRow" class="hidden">
                        <td colspan="10" class="text-center py-12 text-gray-500">
                            Tidak ada siswa pada kelas yang dipilih.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-wrapper {
        width: 100% !important;
    }

    .ts-control {
        border-radius: 1rem !important;
        border-color: #e5e7eb !important;
        padding: 0.75rem 1rem !important;
        background: #FAFCFB !important;
        min-height: 48px !important;
        box-shadow: none !important;
    }

    .ts-control.focus {
        border-color: #4D9A72 !important;
        box-shadow: 0 0 0 2px rgba(77, 154, 114, 0.25) !important;
    }

    .ts-dropdown {
        border-radius: 1rem !important;
        overflow: hidden !important;
        border-color: #e5e7eb !important;
        z-index: 99999 !important;
    }

    .ts-dropdown .option {
        padding: 0.75rem 1rem !important;
    }

    .ts-dropdown .active {
        background: #EEF7F1 !important;
        color: #2F7D55 !important;
    }
</style>

<script>
    const opsiOrangtua = document.getElementById('opsi_orangtua');
    const buatBaruWrapper = document.getElementById('buatBaruWrapper');

    function toggleOpsiOrangtua() {
        if (!opsiOrangtua) return;

        const selected = opsiOrangtua.value;

        if (buatBaruWrapper) {
            buatBaruWrapper.classList.add('hidden');
        }

        if (selected === 'buat_baru' && buatBaruWrapper) {
            buatBaruWrapper.classList.remove('hidden');
        }
    }

    if (opsiOrangtua) {
        opsiOrangtua.addEventListener('change', toggleOpsiOrangtua);
        toggleOpsiOrangtua();
    }

    const filterKelas = document.getElementById('filterKelas');
    const siswaRows = document.querySelectorAll('.siswa-row');
    const jumlahSiswaTampil = document.getElementById('jumlahSiswaTampil');
    const emptyFilterRow = document.getElementById('emptyFilterRow');

    function filterSiswaByKelas() {
        const kelasDipilih = filterKelas.value;
        let totalTampil = 0;

        siswaRows.forEach(function(row) {
            const kelasRow = row.dataset.kelas || '';

            if (kelasDipilih === '' || kelasRow === kelasDipilih) {
                row.style.display = '';
                totalTampil++;

                const noCell = row.querySelector('.no-cell');
                if (noCell) {
                    noCell.textContent = totalTampil;
                }

            } else {
                row.style.display = 'none';
            }
        });

        jumlahSiswaTampil.textContent = totalTampil;

        if (emptyFilterRow) {
            if (totalTampil === 0 && siswaRows.length > 0) {
                emptyFilterRow.classList.remove('hidden');
            } else {
                emptyFilterRow.classList.add('hidden');
            }
        }
    }

    if (filterKelas) {
        filterKelas.addEventListener('change', filterSiswaByKelas);
        filterSiswaByKelas();
    }

    function initSelectOrangtua(scope = document) {
        scope.querySelectorAll('.select-orangtua').forEach(function(select) {
            if (!select.tomselect) {
                new TomSelect(select, {
                    create: false,
                    allowEmptyOption: true,
                    dropdownParent: 'body',
                    placeholder: 'Cari nama orang tua atau nomor telepon...',
                    searchField: ['text'],
                    sortField: {
                        field: 'text',
                        direction: 'asc'
                    }
                });
            }
        });
    }

    function openEditModal(id) {
        const modal = document.getElementById(id);

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(function() {
            initSelectOrangtua(modal);
        }, 100);
    }

    function closeEditModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    initSelectOrangtua();

    document.querySelectorAll('.btn-detail-orangtua').forEach(function(button) {
        button.addEventListener('click', function() {
            const nama = this.dataset.nama;
            const phone = this.dataset.phone;
            const siswa = this.dataset.siswa;
            const nis = this.dataset.nis;

            Swal.fire({
                title: 'Data Orang Tua',
                html: `
                    <div style="text-align:left; line-height:1.8">
                        <p><b>Nama Orang Tua:</b><br>${nama}</p>
                        <p><b>No. Telepon:</b><br>${phone}</p>
                        <p><b>Siswa:</b><br>${siswa}</p>
                        <p><b>NIS Login Orang Tua:</b><br>${nis}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#2F7D55',
                confirmButtonText: 'Tutup'
            });
        });
    });

    document.querySelectorAll('.delete-siswa-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Siswa?',
                text: 'Data siswa yang dihapus tidak bisa digunakan lagi.',
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
