@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

        <!-- HERO HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    RIWAYAT SETORAN QURAN
                </div>

                <h1 class="text-4xl font-bold">
                    Riwayat Setoran Quran
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Lihat semua riwayat setoran Quran siswa dari seluruh kelas.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Halaman Aktif
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    Riwayat
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Data setoran siswa
                </p>

                <a href="{{ route('admin.setoran.index') }}"
                class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                    Kembali
                </a>
            </div>

        </div>

    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- INFO SISWA -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <p class="text-gray-500">
                NIS
            </p>

            <h2 class="text-2xl font-bold text-[#1F252D] mt-2">
                {{ $siswa->nis }}
            </h2>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <p class="text-gray-500">
                Nama Siswa
            </p>

            <h2 class="text-2xl font-bold text-[#1F252D] mt-2">
                {{ $siswa->nama }}
            </h2>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <p class="text-gray-500">
                Kelas
            </p>

            <h2 class="text-2xl font-bold text-[#1F252D] mt-2">
                {{ $siswa->kelas->nama_kelas ?? '-' }}
            </h2>
        </div>

    </div>

    <!-- FORM -->
    <form method="POST"
          action="{{ route('admin.setoran.store', $siswa->nis) }}"
          class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Surah
                </label>

                <input type="text"
                       name="surah"
                       value="{{ old('surah') }}"
                       placeholder="Contoh: Al-Baqarah"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Juz (1-30)
                </label>

                <input type="number"
                       name="juz"
                       min="1"
                       max="30"
                       value="{{ old('juz') }}"
                       placeholder="Contoh: 30"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Nilai (0-100)
                </label>

                <input type="number"
                       name="nilai"
                       min="0"
                       max="100"
                       value="{{ old('nilai') }}"
                       placeholder="Contoh: 85"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
            </div>

        </div>

        <!-- JENIS SETORAN -->
        <div class="mt-6">

            <label class="block mb-3 font-semibold text-gray-700">
                Jenis Setoran
            </label>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <label class="cursor-pointer">
                    <input type="radio"
                           name="jenis"
                           value="tilawah"
                           class="peer hidden"
                           {{ old('jenis') == 'tilawah' ? 'checked' : '' }}>

                    <div class="px-5 py-4 rounded-2xl border border-gray-200 bg-[#FAFCFB] text-gray-700 font-semibold peer-checked:bg-[#2F7D55] peer-checked:text-white peer-checked:border-[#2F7D55] transition text-center">
                        Tilawah
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio"
                           name="jenis"
                           value="tahfidz"
                           class="peer hidden"
                           {{ old('jenis') == 'tahfidz' ? 'checked' : '' }}>

                    <div class="px-5 py-4 rounded-2xl border border-gray-200 bg-[#FAFCFB] text-gray-700 font-semibold peer-checked:bg-[#2F7D55] peer-checked:text-white peer-checked:border-[#2F7D55] transition text-center">
                        Tahfidz
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio"
                           name="jenis"
                           value="murajaah"
                           class="peer hidden"
                           {{ old('jenis') == 'murajaah' ? 'checked' : '' }}>

                    <div class="px-5 py-4 rounded-2xl border border-gray-200 bg-[#FAFCFB] text-gray-700 font-semibold peer-checked:bg-[#2F7D55] peer-checked:text-white peer-checked:border-[#2F7D55] transition text-center">
                        Murajaah
                    </div>
                </label>

            </div>

        </div>

        <div class="mt-6">
            <label class="block mb-2 font-semibold text-gray-700">
                Catatan Admin / Guru
            </label>

            <textarea name="keterangan"
                      rows="5"
                      placeholder="Contoh: Tartil baik, suara merdu, perlu latihan ayat 5-7"
                      class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex justify-end gap-4 mt-8">

            <a href="{{ route('admin.setoran.index') }}"
               class="bg-gray-100 text-gray-700 px-6 py-3 rounded-2xl hover:bg-gray-200 transition font-bold">
                Batal
            </a>

            <button type="submit"
                    class="bg-[#2F7D55] text-white px-7 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold">
                Simpan Setoran
            </button>

        </div>

    </form>

</div>

@endsection
