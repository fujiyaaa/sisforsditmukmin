@extends('layoutsOrtu.app')

@section('content')

@php
    /*
     * Dzuhur dan Ashar hanya disabled kalau:
     * - bukan hari libur
     * - guru sudah input
     *
     * Kalau guru belum input, orang tua bisa input semua.
     */
    $disableDzuhurAshar = !$isLibur && $adaInputGuru;

    $jumlahHariIni = 0;

    if (isset($rekapHariIni)) {
        $jumlahHariIni =
            ($rekapHariIni->subuh ? 1 : 0) +
            ($rekapHariIni->dzuhur ? 1 : 0) +
            ($rekapHariIni->ashar ? 1 : 0) +
            ($rekapHariIni->maghrib ? 1 : 0) +
            ($rekapHariIni->isya ? 1 : 0);
    }

    $persenHariIni = ($jumlahHariIni / 5) * 100;
@endphp

<div class="space-y-8">

 {{-- HERO HEADER --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

    <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
    <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div>
            <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                MONITORING SHOLAT
            </div>

            <h1 class="text-4xl font-bold">
                Monitoring Sholat Fardhu
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                {{ $siswa->nama ?? '-' }} • Kelas {{ $siswa->kelas->nama_kelas ?? $siswa->kelas ?? '-' }}
            </p>
        </div>

        <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
            <p class="text-sm text-white/70">
                Hari Ini
            </p>

            <h2 class="text-2xl font-bold mt-1">
                {{ now()->translatedFormat('d M Y') }}
            </h2>

            <p class="text-white/80 text-sm mt-1">
                Monitoring Sholat Fardhu
            </p>

            <a href="{{ route('orangtua.ibadah-sholat.riwayat') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                Lihat Kalender
            </a>
        </div>

    </div>

</div>
    {{-- INFO SISWA + PROGRESS --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

        <div class="xl:col-span-3 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

            <div class="flex items-center gap-4 mb-6">

                <div class="w-16 h-16 rounded-3xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Data Anak
                    </p>

                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        {{ $siswa->nama ?? '-' }}
                    </h2>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">Nama Anak</p>
                    <h3 class="text-lg font-bold text-[#1F252D] mt-1">
                        {{ $siswa->nama ?? '-' }}
                    </h3>
                </div>

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">NIS</p>
                    <h3 class="text-lg font-bold text-[#1F252D] mt-1">
                        {{ $siswa->nis ?? '-' }}
                    </h3>
                </div>

                <div class="rounded-3xl bg-[#F6FAF8] border border-[#E6F4EC] p-5">
                    <p class="text-sm text-gray-500">Kelas</p>
                    <h3 class="text-lg font-bold text-[#1F252D] mt-1">
                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                    </h3>
                </div>

            </div>

        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-7">

            <p class="text-sm text-gray-500">
                Progress Tanggal Ini
            </p>

            <div class="mt-4 flex items-end gap-2">
                <h2 class="text-5xl font-bold text-[#2F7D55]">
                    {{ $jumlahHariIni }}
                </h2>

                <span class="text-gray-400 font-semibold mb-2">
                    /5
                </span>
            </div>

            <div class="mt-5 w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#2F7D55] rounded-full transition-all"
                     style="width: {{ $persenHariIni }}%">
                </div>
            </div>

            <p class="text-sm text-gray-500 mt-4">
                {{ $jumlahHariIni == 5 ? 'Sholat pada tanggal ini sudah lengkap.' : 'Masih ada sholat yang belum dicentang.' }}
            </p>

        </div>

    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#2F7D55'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#2F7D55'
                });
            });
        </script>
    @endif

    {{-- FORM INPUT --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Input Monitoring Sholat
                </h2>

            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                {{ $jumlahHariIni }}/5 Sholat
            </div>

        </div>

        @if($isLibur)

        @elseif($adaInputGuru)

        @else

        @endif

        <form action="{{ route('orangtua.ibadah-sholat.store') }}" method="POST" class="space-y-7">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Tanggal Monitoring
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ $tanggal ?? now()->toDateString() }}"
                       class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                {{-- SUBUH --}}
                <label class="group relative overflow-hidden flex flex-col gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8] transition">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F252D]">Subuh</span>

                        <input type="checkbox"
                               name="subuh"
                               value="1"
                               class="peer w-5 h-5 accent-[#2F7D55]"
                               {{ isset($rekapHariIni) && $rekapHariIni->subuh ? 'checked' : '' }}>
                    </div>


                </label>

                {{-- DZUHUR --}}
                <label class="group relative overflow-hidden flex flex-col gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 {{ $disableDzuhurAshar ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8]' }} transition">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F252D]">Dzuhur</span>

                        <input type="checkbox"
                               name="dzuhur"
                               value="1"
                               class="peer w-5 h-5 accent-[#2F7D55] {{ $disableDzuhurAshar ? 'cursor-not-allowed opacity-50' : '' }}"
                               {{ isset($rekapHariIni) && $rekapHariIni->dzuhur ? 'checked' : '' }}
                               {{ $disableDzuhurAshar ? 'disabled' : '' }}>
                    </div>

                    <p class="text-sm text-gray-400">
                        {{ $disableDzuhurAshar ? '' : '' }}
                    </p>
                </label>

                {{-- ASHAR --}}
                <label class="group relative overflow-hidden flex flex-col gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 {{ $disableDzuhurAshar ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8]' }} transition">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F252D]">Ashar</span>

                        <input type="checkbox"
                               name="ashar"
                               value="1"
                               class="peer w-5 h-5 accent-[#2F7D55] {{ $disableDzuhurAshar ? 'cursor-not-allowed opacity-50' : '' }}"
                               {{ isset($rekapHariIni) && $rekapHariIni->ashar ? 'checked' : '' }}
                               {{ $disableDzuhurAshar ? 'disabled' : '' }}>
                    </div>

                    <p class="text-sm text-gray-400">
                        {{ $disableDzuhurAshar ? '' : '' }}
                    </p>
                </label>

                {{-- MAGHRIB --}}
                <label class="group relative overflow-hidden flex flex-col gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8] transition">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F252D]">Maghrib</span>

                        <input type="checkbox"
                               name="maghrib"
                               value="1"
                               class="peer w-5 h-5 accent-[#2F7D55]"
                               {{ isset($rekapHariIni) && $rekapHariIni->maghrib ? 'checked' : '' }}>
                    </div>


                </label>

                {{-- ISYA --}}
                <label class="group relative overflow-hidden flex flex-col gap-4 bg-[#FAFCFB] border border-gray-200 rounded-[1.5rem] p-5 cursor-pointer hover:border-[#2F7D55] hover:bg-[#F6FAF8] transition">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F252D]">Isya</span>

                        <input type="checkbox"
                               name="isya"
                               value="1"
                               class="peer w-5 h-5 accent-[#2F7D55]"
                               {{ isset($rekapHariIni) && $rekapHariIni->isya ? 'checked' : '' }}>
                    </div>


                </label>

            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Keterangan
                </label>

                <input type="text"
                       name="keterangan"
                       value="{{ $rekapHariIni->keterangan ?? '' }}"
                       placeholder="Contoh: Sholat berjamaah / sakit / bepergian"
                       class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">

                <p class="text-sm text-gray-500">

                </p>

                <button type="submit"
                        class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-8 py-4 rounded-2xl font-bold transition shadow-sm">
                    Simpan Monitoring
                </button>

            </div>

        </form>

    </div>

    {{-- RIWAYAT TERBARU --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Riwayat Terbaru
                </h2>

                <p class="text-gray-500 mt-1">
                    Ringkasan monitoring sholat yang terakhir diinput.
                </p>
            </div>

            <a href="{{ route('orangtua.ibadah-sholat.riwayat') }}"
               class="inline-flex items-center justify-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-3 rounded-2xl font-bold transition">
                Lihat Kalender
            </a>

        </div>

        @if(isset($monitoringSholats) && $monitoringSholats->count() > 0)

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                @foreach($monitoringSholats->take(6) as $tanggalItem => $items)

                    @php
                        $rekap = [
                            'subuh' => $items->contains(fn ($item) => (int) $item->subuh === 1),
                            'dzuhur' => $items->contains(fn ($item) => (int) $item->dzuhur === 1),
                            'ashar' => $items->contains(fn ($item) => (int) $item->ashar === 1),
                            'maghrib' => $items->contains(fn ($item) => (int) $item->maghrib === 1),
                            'isya' => $items->contains(fn ($item) => (int) $item->isya === 1),
                        ];

                        $jumlah =
                            ($rekap['subuh'] ? 1 : 0) +
                            ($rekap['dzuhur'] ? 1 : 0) +
                            ($rekap['ashar'] ? 1 : 0) +
                            ($rekap['maghrib'] ? 1 : 0) +
                            ($rekap['isya'] ? 1 : 0);

                        $statusClass = $jumlah == 5
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700';
                    @endphp

                    <div class="border border-gray-100 rounded-[1.5rem] p-5 hover:shadow-sm hover:border-[#DDF3E7] transition">

                        <div class="flex items-center justify-between gap-4 mb-5">

                            <div>
                                <h3 class="font-bold text-[#1F252D]">
                                    {{ \Carbon\Carbon::parse($tanggalItem)->format('d M Y') }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($tanggalItem)->translatedFormat('l') }}
                                </p>
                            </div>

                            <span class="{{ $statusClass }} px-4 py-2 rounded-full text-sm font-bold">
                                {{ $jumlah }}/5
                            </span>

                        </div>

                        <div class="grid grid-cols-5 gap-2 text-xs">

                            <span class="{{ $rekap['subuh'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-center px-2 py-2 rounded-xl font-semibold">
                                Subuh
                            </span>

                            <span class="{{ $rekap['dzuhur'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-center px-2 py-2 rounded-xl font-semibold">
                                Dzuhur
                            </span>

                            <span class="{{ $rekap['ashar'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-center px-2 py-2 rounded-xl font-semibold">
                                Ashar
                            </span>

                            <span class="{{ $rekap['maghrib'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-center px-2 py-2 rounded-xl font-semibold">
                                Maghrib
                            </span>

                            <span class="{{ $rekap['isya'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-center px-2 py-2 rounded-xl font-semibold">
                                Isya
                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-[1.5rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">

                <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                    0
                </div>

                <h3 class="text-xl font-bold text-gray-700">
                    Belum ada riwayat monitoring
                </h3>

                <p class="text-gray-500 mt-2">
                    Silakan input monitoring sholat terlebih dahulu.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
