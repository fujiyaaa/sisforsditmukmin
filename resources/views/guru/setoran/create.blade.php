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
                INPUT SETORAN
            </div>

            <h1 class="text-4xl font-bold">
                Input Setoran Quran
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                Isi data setoran Tahfidz, Murajaah, atau Tilawah siswa.
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

            <a href="{{ route('setoran.index') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                Kembali
            </a>
        </div>

    </div>

</div>

    {{-- INFO SISWA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div class="flex items-center gap-4">

                <div class="w-16 h-16 rounded-3xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Data Siswa
                    </p>

                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        {{ $siswa->nama ?? '-' }}
                    </h2>

                    <p class="text-sm text-[#2F7D55] mt-1 font-semibold">
                        NIS {{ $siswa->nis ?? '-' }} • Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:min-w-[520px]">

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">
                        NIS
                    </p>

                    <h3 class="text-lg font-bold text-[#1F252D] mt-1">
                        {{ $siswa->nis ?? '-' }}
                    </h3>
                </div>

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">
                        Nama
                    </p>

                    <h3 class="text-lg font-bold text-[#1F252D] mt-1 truncate">
                        {{ $siswa->nama ?? '-' }}
                    </h3>
                </div>

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">
                        Kelas
                    </p>

                    <h3 class="text-lg font-bold text-[#1F252D] mt-1">
                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                    </h3>
                </div>

            </div>

        </div>

    </div>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 rounded-[1.5rem] p-6">

            <h3 class="font-bold mb-3">
                Data belum lengkap
            </h3>

            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- FORM SETORAN --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Form Setoran Quran
                </h2>

                <p class="text-gray-500 mt-1">
                    Lengkapi data setoran sesuai hasil hafalan atau bacaan siswa.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                Guru
            </div>

        </div>

        <form action="{{ route('setoran.store', $siswa->nis) }}" method="POST" class="space-y-7">
            @csrf

            {{-- TANGGAL --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Tanggal Setoran
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ old('tanggal', now()->toDateString()) }}"
                       class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
            </div>

            {{-- SURAH + JUZ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Surah
                    </label>

                    <input type="text"
                           name="surah"
                           placeholder="Contoh: Al-Baqarah"
                           value="{{ old('surah') }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Juz
                    </label>

                    <input type="number"
                           name="juz"
                           min="1"
                           max="30"
                           placeholder="Contoh: 30"
                           value="{{ old('juz') }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                </div>

            </div>

            {{-- JENIS SETORAN --}}
            <div>
                <label class="block mb-3 text-sm font-semibold text-gray-700">
                    Jenis Setoran
                </label>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <label class="relative flex items-center justify-between gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8] transition">

                        <div>
                            <p class="font-bold text-[#1F252D]">
                                Tilawah
                            </p>

                        </div>

                        <input type="radio"
                               name="jenis"
                               value="tilawah"
                               class="w-5 h-5 accent-[#2F7D55]"
                               {{ old('jenis') == 'tilawah' ? 'checked' : '' }}>

                    </label>

                    <label class="relative flex items-center justify-between gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8] transition">

                        <div>
                            <p class="font-bold text-[#1F252D]">
                                Tahfidz
                            </p>


                        </div>

                        <input type="radio"
                               name="jenis"
                               value="tahfidz"
                               class="w-5 h-5 accent-[#2F7D55]"
                               {{ old('jenis') == 'tahfidz' ? 'checked' : '' }}>

                    </label>

                    <label class="relative flex items-center justify-between gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8] transition">

                        <div>
                            <p class="font-bold text-[#1F252D]">
                                Murajaah
                            </p>

                        </div>

                        <input type="radio"
                               name="jenis"
                               value="murajaah"
                               class="w-5 h-5 accent-[#2F7D55]"
                               {{ old('jenis') == 'murajaah' ? 'checked' : '' }}>

                    </label>

                </div>
            </div>

            {{-- NILAI --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Nilai
                </label>

                <input type="number"
                       name="nilai"
                       min="0"
                       max="100"
                       placeholder="Contoh: 85"
                       value="{{ old('nilai') }}"
                       class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">

                <p class="text-xs text-gray-400 mt-2">
                    Masukkan nilai dari 0 sampai 100.
                </p>
            </div>

            {{-- KETERANGAN --}}
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Catatan Guru
                </label>

                <textarea name="keterangan"
                          rows="5"
                          placeholder="Contoh: Tartil baik, suara jelas, perlu latihan ayat 5-7"
                          class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">{{ old('keterangan') }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-100">


                <div class="flex flex-col sm:flex-row gap-3">

                    <a href="{{ route('setoran.index') }}"
                       class="inline-flex items-center justify-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-7 py-4 rounded-2xl font-semibold transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-8 py-4 rounded-2xl font-semibold transition shadow-sm">
                        Simpan Setoran
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonText: 'Oke',
                confirmButtonColor: '#2F7D55'
            });
        });
    </script>
@endif

@endsection
