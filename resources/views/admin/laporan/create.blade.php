@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex justify-between items-center">

        <div>
            <h1 class="text-3xl font-bold text-[#1F6B4A]">
                Tulis Laporan Siswa
            </h1>

            <p class="text-gray-500 mt-2">
                Admin dapat menginput prestasi, pelanggaran, atau informasi siswa.
            </p>
        </div>

        <a href="{{ route('admin.laporan.index') }}"
           class="px-6 py-3 border border-[#4D9A72] text-[#1F6B4A] rounded-2xl hover:bg-[#4D9A72] hover:text-white transition">
            Kembali
        </a>

    </div>

    <!-- INFO SISWA -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <p class="text-sm text-gray-500">NIS</p>
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $siswa->nis }}
                </h2>
            </div>

            <div>
                <p class="text-sm text-gray-500">Nama Siswa</p>
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $siswa->nama }}
                </h2>
            </div>

            <div>
                <p class="text-sm text-gray-500">Kelas</p>
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
                </h2>
            </div>

        </div>

    </div>

    <!-- ERROR VALIDATION -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 rounded-2xl p-5">
            <h3 class="font-bold mb-2">Data belum lengkap:</h3>

            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form action="{{ route('admin.laporan.store', $siswa->nis) }}" method="POST" class="space-y-6">
            @csrf

            <!-- JENIS LAPORAN -->
            <div>
                <label class="block mb-3 font-semibold">
                    Jenis Laporan
                </label>

                <div class="flex gap-6 flex-wrap">

                    <label class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 px-4 py-3 rounded-xl cursor-pointer">
                        <input type="radio"
                               name="jenis"
                               value="prestasi"
                               {{ old('jenis') == 'prestasi' ? 'checked' : '' }}
                               onchange="ubahJenisLaporan()">
                        <span>🏆 Prestasi</span>
                    </label>

                    <label class="flex items-center gap-2 bg-red-50 border border-red-200 px-4 py-3 rounded-xl cursor-pointer">
                        <input type="radio"
                               name="jenis"
                               value="pelanggaran"
                               {{ old('jenis') == 'pelanggaran' ? 'checked' : '' }}
                               onchange="ubahJenisLaporan()">
                        <span>⚠️ Pelanggaran</span>
                    </label>

                    <label class="flex items-center gap-2 bg-blue-50 border border-blue-200 px-4 py-3 rounded-xl cursor-pointer">
                        <input type="radio"
                               name="jenis"
                               value="informasi"
                               {{ old('jenis') == 'informasi' ? 'checked' : '' }}
                               onchange="ubahJenisLaporan()">
                        <span>ℹ️ Informasi</span>
                    </label>

                </div>
            </div>

            <!-- JUDUL -->
            <div>
                <label class="block mb-2 font-semibold">
                    Judul Berita / Laporan
                </label>

                <input type="text"
                       name="judul"
                       value="{{ old('judul') }}"
                       placeholder="Contoh: Juara 1 Lomba Cerdas Cermat"
                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <!-- DESKRIPSI -->
            <div>
                <label class="block mb-2 font-semibold">
                    Isi Berita / Deskripsi
                </label>

                <textarea name="deskripsi"
                          rows="5"
                          placeholder="Jelaskan secara detail laporan siswa..."
                          class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- TANGGAL DAN DETAIL -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-semibold">
                        Tanggal Kejadian
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                </div>

                <div id="box-detail-jenis" class="hidden">
                    <label id="label-detail-jenis" class="block mb-2 font-semibold">
                        Detail Laporan
                    </label>

                    <select name="tingkat"
                            id="tingkat"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>

            </div>

            <!-- CATATAN -->
            <div>
                <label class="block mb-2 font-semibold">
                    Catatan Admin
                </label>

                <textarea name="catatan"
                          rows="4"
                          placeholder="Catatan tambahan jika ada..."
                          class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('catatan') }}</textarea>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-4 pt-4">

                <a href="{{ route('admin.laporan.index') }}"
                   class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-[#4D9A72] text-white font-semibold hover:bg-[#3F8260] transition">
                    Simpan Laporan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function ubahJenisLaporan() {
        const jenis = document.querySelector('input[name="jenis"]:checked')?.value;
        const box = document.getElementById('box-detail-jenis');
        const label = document.getElementById('label-detail-jenis');
        const select = document.getElementById('tingkat');

        select.innerHTML = '<option value="">-- Pilih --</option>';

        if (!jenis) {
            box.classList.add('hidden');
            return;
        }

        box.classList.remove('hidden');

        let options = [];

        if (jenis === 'prestasi') {
            label.innerText = 'Tingkat Prestasi';
            options = [
                'Sekolah',
                'Kecamatan',
                'Kabupaten',
                'Provinsi',
                'Nasional',
                'Internasional'
            ];
        }

        if (jenis === 'pelanggaran') {
            label.innerText = 'Jenis Pelanggaran';
            options = [
                'Terlambat',
                'Tidak Mengerjakan Tugas',
                'Tidak Mengikuti Kegiatan',
                'Melanggar Tata Tertib',
                'Berkelahi',
                'Tidak Membawa Perlengkapan',
                'Lainnya'
            ];
        }

        if (jenis === 'informasi') {
            label.innerText = 'Jenis Informasi';
            options = [
                'Pengumuman',
                'Catatan Perkembangan',
                'Kegiatan Sekolah',
                'Kesehatan',
                'Administrasi',
                'Lainnya'
            ];
        }

        const oldValue = "{{ old('tingkat') }}";

        options.forEach(function(item) {
            const option = document.createElement('option');
            option.value = item;
            option.textContent = item;

            if (item === oldValue) {
                option.selected = true;
            }

            select.appendChild(option);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        ubahJenisLaporan();
    });
</script>

@endsection
