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
                    LAPORAN SISWA
                </div>

                <h1 class="text-4xl font-bold">
                    Tulis Laporan Siswa
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Input laporan prestasi, pelanggaran, atau informasi siswa secara lengkap.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Siswa Dipilih
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $siswa->nama ?? '-' }}
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    NIS: {{ $siswa->nis ?? '-' }}
                </p>

                <a href="{{ url('/guru/laporan-prestasi-pelanggaran') }}"
                class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- INFO SISWA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-xl">
                {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
            </div>

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    {{ $siswa->nama }}
                </h2>

                <p class="text-gray-500 mt-1">
                    NIS: {{ $siswa->nis }}
                    |
                    Kelas: {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-[2rem] p-6 shadow-sm">
            <h3 class="font-bold mb-3">
                Data belum lengkap:
            </h3>

            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Form Laporan
            </h2>

            <p class="text-gray-500 mt-1">
                Isi data laporan dengan lengkap.
            </p>
        </div>

        <form method="POST"
              action="{{ route('laporan.store', $siswa->nis) }}"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

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

                        <option value="prestasi" {{ old('jenis') == 'prestasi' ? 'selected' : '' }}>
                            Prestasi
                        </option>

                        <option value="pelanggaran" {{ old('jenis') == 'pelanggaran' ? 'selected' : '' }}>
                            Pelanggaran
                        </option>

                        <option value="informasi" {{ old('jenis') == 'informasi' ? 'selected' : '' }}>
                            Informasi
                        </option>

                    </select>

                    @error('jenis')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- TANGGAL --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>

                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- JUDUL --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul
                    </label>

                    <input type="text"
                           name="judul"
                           value="{{ old('judul') }}"
                           placeholder="Masukkan judul laporan"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>

                    @error('judul')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- TINGKAT --}}
                <div id="tingkatWrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tingkat
                    </label>

                    <select name="tingkat"
                            id="tingkat"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                        <option value="">
                            Pilih Tingkat
                        </option>

                        <option value="Kelas" {{ old('tingkat') == 'Kelas' ? 'selected' : '' }}>
                            Kelas
                        </option>

                        <option value="Sekolah" {{ old('tingkat') == 'Sekolah' ? 'selected' : '' }}>
                            Sekolah
                        </option>

                        <option value="Kecamatan" {{ old('tingkat') == 'Kecamatan' ? 'selected' : '' }}>
                            Kecamatan
                        </option>

                        <option value="Kabupaten/Kota" {{ old('tingkat') == 'Kabupaten/Kota' ? 'selected' : '' }}>
                            Kabupaten/Kota
                        </option>

                        <option value="Provinsi" {{ old('tingkat') == 'Provinsi' ? 'selected' : '' }}>
                            Provinsi
                        </option>

                        <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>
                            Nasional
                        </option>

                        <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>
                            Internasional
                        </option>

                    </select>

                    <p class="text-xs text-gray-400 mt-2">
                        Diisi untuk laporan prestasi.
                    </p>

                    @error('tingkat')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
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
                        Format: JPG, PNG, PDF. Maksimal 2MB.
                    </p>

                    @error('lampiran')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              rows="5"
                              placeholder="Tuliskan detail laporan siswa"
                              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                              required>{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- CATATAN --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan
                    </label>

                    <textarea name="catatan"
                              rows="3"
                              placeholder="Catatan tambahan jika ada"
                              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('catatan') }}</textarea>

                    @error('catatan')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('laporan.index') }}"
                   class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold">
                    Batal
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-2xl bg-[#2F7D55] text-white hover:bg-[#256B47] transition font-bold">
                    Simpan Laporan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    const jenisSelect = document.getElementById('jenis');
    const tingkatWrapper = document.getElementById('tingkatWrapper');
    const lampiranWrapper = document.getElementById('lampiranWrapper');

    function toggleJenisFields() {
        if (!jenisSelect) return;

        const jenis = jenisSelect.value;

        if (jenis === 'prestasi') {
            if (tingkatWrapper) tingkatWrapper.style.display = 'block';
            if (lampiranWrapper) lampiranWrapper.style.display = 'block';
        } else {
            if (tingkatWrapper) tingkatWrapper.style.display = 'none';
            if (lampiranWrapper) lampiranWrapper.style.display = 'none';
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
