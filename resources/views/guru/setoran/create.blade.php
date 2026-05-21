@extends('layoutsguru.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8 flex justify-between items-center">

        <div>
            <h1 class="text-3xl font-bold text-[#1F6B4A]">
                Input Setoran Quran
            </h1>

            <p class="text-gray-500 mt-2">
                Isi data setoran Quran siswa.
            </p>
        </div>

        <a href="{{ route('setoran.index') }}"
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

    <!-- FORM SETORAN -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form action="{{ route('setoran.store', $siswa->nis) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 font-semibold">Surah</label>
                    <input type="text"
                           name="surah"
                           placeholder="Contoh: Al-Baqarah"
                           value="{{ old('surah') }}"
                           class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Juz (1-30)</label>
                    <input type="number"
                           name="juz"
                           min="1"
                           max="30"
                           placeholder="Contoh: 30"
                           value="{{ old('juz') }}"
                           class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                </div>

            </div>

            <div>
                <label class="block mb-3 font-semibold">Jenis Setoran</label>

                <div class="flex gap-6 flex-wrap">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="jenis" value="tilawah" {{ old('jenis') == 'tilawah' ? 'checked' : '' }}>
                        <span>Tilawah</span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="jenis" value="tahfidz" {{ old('jenis') == 'tahfidz' ? 'checked' : '' }}>
                        <span>Tahfidz</span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="jenis" value="murajaah" {{ old('jenis') == 'murajaah' ? 'checked' : '' }}>
                        <span>Murajaah</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block mb-2 font-semibold">Nilai (0-100)</label>
                <input type="number"
                       name="nilai"
                       min="0"
                       max="100"
                       placeholder="Contoh: 85"
                       value="{{ old('nilai') }}"
                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div>
                <label class="block mb-2 font-semibold">Catatan Guru (Opsional)</label>
                <textarea name="keterangan"
                          rows="4"
                          placeholder="Contoh: Tartil baik, suara merdu, perlu latihan ayat 5-7"
                          class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4">

                <a href="{{ route('setoran.index') }}"
                   class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-[#4D9A72] text-white font-semibold hover:bg-[#3F8260] transition">
                    Simpan Setoran
                </button>

            </div>

        </form>

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

@endsection
