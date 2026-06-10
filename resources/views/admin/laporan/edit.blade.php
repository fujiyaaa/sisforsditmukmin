@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-sm font-semibold text-[#2F7D55] mb-2">
                    Edit Laporan Siswa
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-[#1F252D]">
                    Perbarui Laporan
                </h1>

                <p class="text-gray-500 mt-3 max-w-2xl">
                    Ubah data laporan prestasi, pelanggaran, atau informasi siswa.
                </p>
            </div>

            <a href="{{ route('admin.laporan.index') }}"
               class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-2xl transition">
                Kembali
            </a>
        </div>
    </div>

    {{-- INFO SISWA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-xl">
                {{ strtoupper(substr($laporan->siswa->nama ?? '-', 0, 1)) }}
            </div>

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    {{ $laporan->siswa->nama ?? '-' }}
                </h2>

                <p class="text-gray-500 mt-1">
                    NIS: {{ $laporan->siswa->nis ?? '-' }}
                    |
                    Kelas: {{ $laporan->siswa->kelas->nama_kelas ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    {{-- FORM EDIT --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Form Edit Laporan
            </h2>

            <p class="text-gray-500 mt-1">
                Perbarui data laporan sesuai kebutuhan.
            </p>
        </div>

        <form method="POST"
              action="{{ route('admin.laporan.update', $laporan->id) }}"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- JENIS --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Laporan
                    </label>

                    <select name="jenis"
                            id="jenis"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                            required>

                        <option value="">
                            Pilih jenis laporan
                        </option>

                        <option value="prestasi" {{ old('jenis', $laporan->jenis) == 'prestasi' ? 'selected' : '' }}>
                            Prestasi
                        </option>

                        <option value="pelanggaran" {{ old('jenis', $laporan->jenis) == 'pelanggaran' ? 'selected' : '' }}>
                            Pelanggaran
                        </option>

                        <option value="informasi" {{ old('jenis', $laporan->jenis) == 'informasi' ? 'selected' : '' }}>
                            Informasi
                        </option>

                    </select>
                </div>

                {{-- TANGGAL --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

                {{-- JUDUL --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul
                    </label>

                    <input type="text"
                           name="judul"
                           value="{{ old('judul', $laporan->judul) }}"
                           placeholder="Masukkan judul laporan"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

                {{-- TINGKAT --}}
                <div id="tingkatWrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tingkat
                    </label>

                    <select name="tingkat"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                        <option value="">
                            Pilih Tingkat
                        </option>

                        <option value="Kelas" {{ old('tingkat', $laporan->tingkat) == 'Kelas' ? 'selected' : '' }}>
                            Kelas
                        </option>

                        <option value="Sekolah" {{ old('tingkat', $laporan->tingkat) == 'Sekolah' ? 'selected' : '' }}>
                            Sekolah
                        </option>

                        <option value="Kecamatan" {{ old('tingkat', $laporan->tingkat) == 'Kecamatan' ? 'selected' : '' }}>
                            Kecamatan
                        </option>

                        <option value="Kabupaten/Kota" {{ old('tingkat', $laporan->tingkat) == 'Kabupaten/Kota' ? 'selected' : '' }}>
                            Kabupaten/Kota
                        </option>

                        <option value="Provinsi" {{ old('tingkat', $laporan->tingkat) == 'Provinsi' ? 'selected' : '' }}>
                            Provinsi
                        </option>

                        <option value="Nasional" {{ old('tingkat', $laporan->tingkat) == 'Nasional' ? 'selected' : '' }}>
                            Nasional
                        </option>

                        <option value="Internasional" {{ old('tingkat', $laporan->tingkat) == 'Internasional' ? 'selected' : '' }}>
                            Internasional
                        </option>

                    </select>

                    <p class="text-xs text-gray-400 mt-2">
                        Diisi untuk laporan prestasi.
                    </p>
                </div>

                {{-- LAMPIRAN --}}
                <div id="lampiranWrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Sertifikat / Lampiran
                    </label>

                    <input type="file"
                           name="lampiran"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <p class="text-xs text-gray-400 mt-2">
                        Kosongkan jika tidak ingin mengganti lampiran.
                    </p>
                </div>

                {{-- PREVIEW LAMPIRAN --}}
                @if($laporan->sertifikat)
                    @php
                        $ext = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                    @endphp

                    <div id="previewLampiran" class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Lampiran Saat Ini
                        </label>

                        <div class="rounded-[1.5rem] border border-gray-200 bg-[#FAFCFB] p-4">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-sm text-gray-500">
                                    File yang sedang tersimpan
                                </p>

                                <a href="{{ asset('storage/' . $laporan->sertifikat) }}"
                                   target="_blank"
                                   class="text-[#2F7D55] font-bold hover:underline">
                                    Buka Lampiran
                                </a>
                            </div>

                            @if($isImage)
                                <div class="rounded-2xl bg-white border border-gray-100 p-4 flex justify-center">
                                    <img src="{{ asset('storage/' . $laporan->sertifikat) }}"
                                         alt="Lampiran {{ $laporan->judul }}"
                                         class="max-h-[280px] rounded-2xl object-contain">
                                </div>
                            @else
                                <div class="rounded-2xl bg-white border border-gray-100 p-6 text-center text-gray-500">
                                    Lampiran berupa file. Klik “Buka Lampiran” untuk melihat.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- DESKRIPSI --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              rows="5"
                              placeholder="Tuliskan detail laporan siswa"
                              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                              required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                </div>

                {{-- CATATAN --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan
                    </label>

                    <textarea name="catatan"
                              rows="3"
                              placeholder="Catatan tambahan jika ada"
                              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('catatan', $laporan->catatan) }}</textarea>
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('admin.laporan.index') }}"
                   class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold">
                    Batal
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-2xl bg-[#2F7D55] text-white hover:bg-[#256B47] transition font-bold">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    const jenisSelect = document.getElementById('jenis');
    const tingkatWrapper = document.getElementById('tingkatWrapper');
    const lampiranWrapper = document.getElementById('lampiranWrapper');
    const previewLampiran = document.getElementById('previewLampiran');

    function toggleJenisFields() {
        if (!jenisSelect) return;

        const jenis = jenisSelect.value;

        if (jenis === 'prestasi') {
            if (tingkatWrapper) tingkatWrapper.style.display = 'block';
            if (lampiranWrapper) lampiranWrapper.style.display = 'block';
            if (previewLampiran) previewLampiran.style.display = 'block';
        } else {
            if (tingkatWrapper) tingkatWrapper.style.display = 'none';
            if (lampiranWrapper) lampiranWrapper.style.display = 'none';
            if (previewLampiran) previewLampiran.style.display = 'none';
        }
    }

    if (jenisSelect) {
        jenisSelect.addEventListener('change', toggleJenisFields);
        toggleJenisFields();
    }
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
