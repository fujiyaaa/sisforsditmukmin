@extends('layoutsGuru.app')

@section('content')

@php
    $dataSiswa = $siswa ?? $laporan->siswa ?? null;
@endphp

<!-- HERO HEADER -->
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

    <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
    <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                EDIT LAPORAN
            </div>

            <h1 class="text-4xl font-bold">
                Edit Laporan Siswa
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                Perbarui laporan prestasi, pelanggaran, atau informasi siswa.
            </p>
        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Siswa Dipilih
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ $dataSiswa->nama ?? '-' }}
            </h2>

            <p class="text-white/80 text-sm mt-1">
                NIS: {{ $dataSiswa->nis ?? '-' }}
            </p>

            <p class="text-white/60 text-xs mt-1">
                Kelas: {{ $dataSiswa->kelas->nama_kelas ?? '-' }}
            </p>

            <a href="{{ url('/guru/laporan-prestasi-pelanggaran') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                Kembali
            </a>
        </div>

    </div>

</div>

    <div class="bg-white rounded-3xl shadow-md p-8">

        <h2 class="text-2xl font-bold text-[#1F252D] mb-6">
            Form Edit Laporan
        </h2>

        <form method="POST"
              action="{{ route('laporan.update', $laporan->id) }}"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Laporan
                    </label>

                    <select name="jenis"
                            id="jenis"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                            required>

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

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul
                    </label>

                    <input type="text"
                           name="judul"
                           value="{{ old('judul', $laporan->judul) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

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
                </div>

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

                @if($laporan->sertifikat)
                    @php
                        $ext = strtolower(pathinfo($laporan->sertifikat, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                    @endphp

                    <div id="previewLampiran" class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Lampiran Saat Ini
                        </label>

                        <div class="rounded-3xl border border-gray-200 bg-[#FAFCFB] p-4">

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

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              rows="5"
                              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                              required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan
                    </label>

                    <textarea name="catatan"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('catatan', $laporan->catatan) }}</textarea>
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('laporan.index') }}"
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
