@extends('layoutsAdmin.app')

@section('content')

@php
    $rekapCollection = collect($rekapKelas);

    if ($jenisRekap == 'sholat') {
        $totalTerisi = $rekapCollection->sum('total_sholat');
        $totalTarget = $rekapCollection->sum('target_sholat');

        $persentaseTotal = $totalTarget > 0
            ? round(($totalTerisi / $totalTarget) * 100, 2)
            : 0;

        $kelasTertinggi = $rekapCollection->sortByDesc('persentase_sholat')->first();

        $persentaseKelasTertinggi = $kelasTertinggi
            ? $kelasTertinggi['persentase_sholat']
            : 0;

        $labelJenis = 'Sholat Fardhu';
        $labelPersentase = 'Persentase Sholat Keseluruhan';
        $labelTotal = 'Total Checklist Sholat';
        $labelTarget = 'checklist';
        $warnaUtama = 'text-[#2F7D55]';
        $warnaProgress = 'bg-[#4D9A72]';
        $bgSoft = 'bg-[#EEF7F1]';
        $borderAccent = 'border-[#4D9A72]';
        $badgeLabel = 'SHOLAT';
    } else {
        $totalTerisi = $rekapCollection->sum('hadir');
        $totalTarget = $rekapCollection->sum('target_absensi');

        $persentaseTotal = $totalTarget > 0
            ? round(($totalTerisi / $totalTarget) * 100, 2)
            : 0;

        $kelasTertinggi = $rekapCollection->sortByDesc('persentase_absensi')->first();

        $persentaseKelasTertinggi = $kelasTertinggi
            ? $kelasTertinggi['persentase_absensi']
            : 0;

        $labelJenis = 'Absensi';
        $labelPersentase = 'Persentase Absensi Keseluruhan';
        $labelTotal = 'Total Kehadiran';
        $labelTarget = 'hadir';
        $warnaUtama = 'text-blue-600';
        $warnaProgress = 'bg-blue-600';
        $bgSoft = 'bg-blue-50';
        $borderAccent = 'border-blue-600';
        $badgeLabel = 'ABSENSI';
    }
@endphp

<div class="space-y-8">

    <!-- HERO HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    REKAP PERSENTASE SHOLAT & ABSENSI
                </div>

                <h1 class="text-4xl font-bold">
                    Rekap Persentase {{ $labelJenis }}
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Pantau persentase {{ strtolower($labelJenis) }} per kelas dan per siswa berdasarkan bulan serta tahun ajaran.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Periode Aktif
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $daftarBulan[$bulanAngka] }}
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Tahun Ajaran {{ $tahunAjaran }}
                </p>

                <p class="text-white/60 text-xs mt-1">
                    Tahun kalender: {{ $tahun }}
                </p>
            </div>

        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Rekapitulasi
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih jenis rekap, bulan, dan tahun ajaran yang ingin ditampilkan.
                </p>
            </div>

            <a href="{{ route('admin.rekap-persentase.index') }}"
               class="bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl hover:bg-gray-200 transition text-center font-semibold">
                Reset Filter
            </a>
        </div>

        <form method="GET"
              action="{{ route('admin.rekap-persentase.index') }}"
              class="grid grid-cols-1 md:grid-cols-5 gap-5">

            <!-- JENIS REKAP -->
            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Jenis Rekap
                </label>

                <select name="jenis_rekap"
                        onchange="this.form.submit()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                    <option value="sholat" {{ $jenisRekap == 'sholat' ? 'selected' : '' }}>
                        Rekap Sholat
                    </option>

                    <option value="absensi" {{ $jenisRekap == 'absensi' ? 'selected' : '' }}>
                        Rekap Absensi
                    </option>
                </select>
            </div>

            <!-- BULAN -->
            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Pilih Bulan
                </label>

                <select name="bulan"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                    @foreach ($daftarBulan as $key => $namaBulan)
                        <option value="{{ $key }}" {{ $bulanAngka == $key ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TAHUN AJARAN -->
            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Tahun Ajaran
                </label>

                <select name="tahun_ajaran"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                    @foreach ($daftarTahunAjaran as $itemTahunAjaran)
                        <option value="{{ $itemTahunAjaran }}" {{ $tahunAjaran == $itemTahunAjaran ? 'selected' : '' }}>
                            {{ $itemTahunAjaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($jenisRekap == 'absensi')
                <!-- HARI ABSENSI -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Hari Efektif
                    </label>

                    <input type="number"
                           name="hari_efektif"
                           min="1"
                           max="31"
                           value="{{ request('hari_efektif') }}"
                           placeholder="Otomatis: {{ $jumlahHariAbsensiOtomatis }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <p class="text-xs text-gray-400 mt-1">
                        Kosongkan untuk otomatis Senin–Jumat.
                    </p>
                </div>
            @else
                <!-- HARI SHOLAT -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Hari Sholat
                    </label>

                    <div class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50 text-gray-700">
                        {{ $jumlahHariSholat }} hari
                    </div>

                    <p class="text-xs text-gray-400 mt-1">
                        Otomatis hari kalender.
                    </p>
                </div>
            @endif

            <!-- BUTTON -->
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition font-semibold">
                    Tampilkan
                </button>
            </div>

        </form>

        <div class="mt-6 {{ $bgSoft }} border border-gray-100 rounded-2xl p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="font-bold {{ $warnaUtama }}">
                        {{ $labelJenis }}
                    </p>

                    @if ($jenisRekap == 'sholat')
                        <p class="text-sm text-gray-500 mt-1">
                            Target sholat = jumlah hari kalender × 5 waktu sholat × jumlah siswa.
                        </p>
                    @else
                        <p class="text-sm text-gray-500 mt-1">
                            Target absensi menggunakan {{ $jumlahHariAbsensi }} hari efektif.
                            @if ($hariEfektifManual)
                                Hari efektif diinput manual oleh admin.
                            @else
                                Hari efektif otomatis dihitung dari Senin–Jumat.
                            @endif
                        </p>
                    @endif
                </div>

                <div class="{{ $bgSoft }} {{ $warnaUtama }} bg-white px-4 py-2 rounded-2xl font-bold text-sm tracking-wide">
                    {{ $badgeLabel }}
                </div>
            </div>
        </div>

    </div>

    <!-- RINGKASAN MODERN -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- TOTAL PERSENTASE BESAR -->
        <div class="xl:col-span-2 bg-white rounded-3xl shadow-md p-8 border border-gray-100">

            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">

                <div>
                    <p class="text-gray-500">
                        {{ $labelPersentase }}
                    </p>

                    <div class="flex items-end gap-3 mt-3">
                        <h2 class="text-6xl font-bold {{ $warnaUtama }}">
                            {{ $persentaseTotal }}%
                        </h2>

                        <span class="text-gray-400 mb-2">
                            keseluruhan
                        </span>
                    </div>
                </div>

                <div class="px-5 py-3 rounded-2xl {{ $bgSoft }} {{ $warnaUtama }} font-bold text-sm uppercase tracking-wide">
                    {{ $badgeLabel }}
                </div>

            </div>

            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="{{ $warnaProgress }} h-4 rounded-full transition-all"
                     style="width: {{ $persentaseTotal }}%">
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mt-5">
                <p class="text-gray-500">
                    Total tercatat:
                    <span class="font-bold text-[#1F252D]">
                        {{ $totalTerisi }}
                    </span>
                    dari target
                    <span class="font-bold text-[#1F252D]">
                        {{ $totalTarget }}
                    </span>
                    {{ $labelTarget }}
                </p>

                <div class="{{ $bgSoft }} {{ $warnaUtama }} px-4 py-2 rounded-2xl font-semibold text-sm">
                    {{ $labelTotal }}
                </div>
            </div>

        </div>

        <!-- KELAS TERTINGGI -->
        <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-gray-500">
                        Kelas Tertinggi
                    </p>

                    <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                        {{ $kelasTertinggi['kelas'] ?? '-' }}
                    </h2>
                </div>

                <div class="px-4 py-2 rounded-2xl bg-yellow-50 text-yellow-700 font-bold text-sm tracking-wide">
                    TOP
                </div>
            </div>

            <p class="text-gray-500">
                Persentase terbaik pada rekap ini:
            </p>

            <h3 class="text-5xl font-bold {{ $warnaUtama }} mt-3">
                {{ $persentaseKelasTertinggi }}%
            </h3>

            <div class="w-full bg-gray-200 rounded-full h-3 mt-5">
                <div class="{{ $warnaProgress }} h-3 rounded-full"
                     style="width: {{ $persentaseKelasTertinggi }}%">
                </div>
            </div>

        </div>

    </div>

    <!-- MINI STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="border-l-4 border-[#4D9A72] pl-5">
                <p class="text-gray-500">
                    Jumlah Kelas
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    {{ count($rekapKelas) }}
                </h2>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="border-l-4 border-blue-600 pl-5">
                <p class="text-gray-500">
                    Total Siswa
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    {{ collect($rekapKelas)->sum('jumlah_siswa') }}
                </h2>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
            <div class="border-l-4 border-yellow-500 pl-5">
                <p class="text-gray-500">
                    @if ($jenisRekap == 'sholat')
                        Hari Sholat
                    @else
                        Hari Efektif Absensi
                    @endif
                </p>

                <h2 class="text-4xl font-bold text-[#1F252D] mt-2">
                    @if ($jenisRekap == 'sholat')
                        {{ $jumlahHariSholat }}
                    @else
                        {{ $jumlahHariAbsensi }}
                    @endif
                </h2>
            </div>
        </div>

    </div>

    <!-- REKAP PER KELAS -->
    <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    @if ($jenisRekap == 'sholat')
                        Rekap Sholat Per Kelas
                    @else
                        Rekap Absensi Per Kelas
                    @endif
                </h2>

                <p class="text-gray-500 mt-1">
                    Klik detail siswa untuk melihat data per siswa.
                </p>
            </div>

            <div class="{{ $bgSoft }} {{ $warnaUtama }} px-5 py-3 rounded-2xl font-semibold">
                {{ count($rekapKelas) }} kelas
            </div>
        </div>

        @if (count($rekapKelas) > 0)

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                @foreach ($rekapKelas as $item)

                    @php
                        $persentaseKelas = $jenisRekap == 'sholat'
                            ? $item['persentase_sholat']
                            : $item['persentase_absensi'];
                    @endphp

                    <div class="bg-[#F8FBF9] rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">

                        <!-- HEADER CARD -->
                        <div class="flex items-start justify-between gap-4 mb-6">

                            <div>
                                <h3 class="text-2xl font-bold text-[#1F252D]">
                                    Kelas {{ $item['kelas'] }}
                                </h3>

                                <p class="text-gray-500 mt-1">
                                    Jumlah Siswa: {{ $item['jumlah_siswa'] }} siswa
                                </p>
                            </div>

                            <div class="{{ $bgSoft }} {{ $warnaUtama }} px-4 py-2 rounded-2xl font-bold">
                                {{ $persentaseKelas }}%
                            </div>

                        </div>

                        @if ($jenisRekap == 'sholat')

                            <!-- SHOLAT CARD -->
                            <div class="bg-white rounded-2xl p-5 border border-gray-100 mb-5">

                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-700">
                                            Persentase Sholat
                                        </p>

                                        <p class="text-sm text-gray-400 mt-1">
                                            {{ $item['total_sholat'] }} / {{ $item['target_sholat'] }} checklist
                                        </p>
                                    </div>

                                    <span class="text-3xl font-bold text-[#2F7D55]">
                                        {{ $item['persentase_sholat'] }}%
                                    </span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-[#4D9A72] h-3 rounded-full"
                                         style="width: {{ $item['persentase_sholat'] }}%">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-400 mt-2">
                                    Target: {{ $jumlahHariSholat }} hari × 5 waktu × {{ $item['jumlah_siswa'] }} siswa
                                </p>

                            </div>

                        @else

                            <!-- ABSENSI CARD -->
                            <div class="bg-white rounded-2xl p-5 border border-gray-100 mb-5">

                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-700">
                                            Persentase Absensi
                                        </p>

                                        <p class="text-sm text-gray-400 mt-1">
                                            {{ $item['hadir'] }} / {{ $item['target_absensi'] }} hadir
                                        </p>
                                    </div>

                                    <span class="text-3xl font-bold text-blue-600">
                                        {{ $item['persentase_absensi'] }}%
                                    </span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-600 h-3 rounded-full"
                                         style="width: {{ $item['persentase_absensi'] }}%">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-400 mt-2">
                                    Target: {{ $jumlahHariAbsensi }} hari efektif × {{ $item['jumlah_siswa'] }} siswa
                                </p>

                            </div>

                            <!-- STATUS ABSENSI -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">

                                <div class="bg-green-50 rounded-2xl p-4 text-center">
                                    <p class="text-sm text-green-700">Hadir</p>
                                    <h4 class="text-2xl font-bold text-green-700 mt-1">
                                        {{ $item['hadir'] }}
                                    </h4>
                                </div>

                                <div class="bg-yellow-50 rounded-2xl p-4 text-center">
                                    <p class="text-sm text-yellow-700">Izin</p>
                                    <h4 class="text-2xl font-bold text-yellow-700 mt-1">
                                        {{ $item['izin'] }}
                                    </h4>
                                </div>

                                <div class="bg-blue-50 rounded-2xl p-4 text-center">
                                    <p class="text-sm text-blue-700">Sakit</p>
                                    <h4 class="text-2xl font-bold text-blue-700 mt-1">
                                        {{ $item['sakit'] }}
                                    </h4>
                                </div>

                                <div class="bg-red-50 rounded-2xl p-4 text-center">
                                    <p class="text-sm text-red-700">Alfa</p>
                                    <h4 class="text-2xl font-bold text-red-700 mt-1">
                                        {{ $item['alfa'] }}
                                    </h4>
                                </div>

                            </div>

                        @endif

                        <!-- BUTTON DETAIL -->
                        <button type="button"
                                onclick="openModalDetail('{{ $item['kelas_id'] }}')"
                                class="w-full bg-[#2F7D55] text-white py-3 rounded-2xl hover:bg-[#256B47] transition font-semibold">
                            Detail Siswa
                        </button>

                    </div>

                    <!-- MODAL DETAIL SISWA -->
                    <div id="modal-detail-{{ $item['kelas_id'] }}"
                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center px-4">

                        <div class="bg-white w-full max-w-6xl rounded-3xl shadow-xl p-8 relative max-h-[85vh] overflow-y-auto">

                            <button type="button"
                                    onclick="closeModalDetail('{{ $item['kelas_id'] }}')"
                                    class="absolute top-5 right-6 text-gray-500 hover:text-red-500 text-3xl font-bold">
                                &times;
                            </button>

                            <div class="mb-6 pr-10">
                                <h3 class="text-2xl font-bold text-[#1F252D]">
                                    Detail Siswa Kelas {{ $item['kelas'] }}
                                </h3>

                                <p class="text-gray-500 mt-1">
                                    @if ($jenisRekap == 'sholat')
                                        Rekap sholat siswa selama {{ $daftarBulan[$bulanAngka] }} {{ $tahunAjaran }}.
                                    @else
                                        Rekap absensi siswa selama {{ $daftarBulan[$bulanAngka] }} {{ $tahunAjaran }}.
                                    @endif
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                @forelse ($item['detail_siswa'] as $siswa)

                                    <div class="bg-[#F8FBF9] rounded-2xl p-5 border border-gray-100">

                                        <div class="flex items-center gap-4 mb-5">

                                            <div class="w-12 h-12 rounded-full bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-lg">
                                                {{ strtoupper(substr($siswa['nama'], 0, 1)) }}
                                            </div>

                                            <div>
                                                <h5 class="font-bold text-[#1F252D]">
                                                    {{ $siswa['nama'] }}
                                                </h5>

                                                <p class="text-sm text-gray-500">
                                                    NIS: {{ $siswa['nis'] }}
                                                </p>
                                            </div>

                                        </div>

                                        @if ($jenisRekap == 'sholat')

                                            <div class="bg-white rounded-2xl p-4">

                                                <div class="flex items-center justify-between mb-2">
                                                    <p class="font-semibold text-gray-700">
                                                        Persentase Sholat
                                                    </p>

                                                    <span class="font-bold text-[#2F7D55]">
                                                        {{ $siswa['persentase_sholat'] }}%
                                                    </span>
                                                </div>

                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-[#4D9A72] h-2 rounded-full"
                                                         style="width: {{ $siswa['persentase_sholat'] }}%">
                                                    </div>
                                                </div>

                                                <p class="text-xs text-gray-400 mt-2">
                                                    {{ $siswa['total_sholat'] }} / {{ $siswa['target_sholat'] }} checklist
                                                </p>

                                            </div>

                                        @else

                                            <div class="bg-white rounded-2xl p-4 mb-4">

                                                <div class="flex items-center justify-between mb-2">
                                                    <p class="font-semibold text-gray-700">
                                                        Persentase Absensi
                                                    </p>

                                                    <span class="font-bold text-blue-600">
                                                        {{ $siswa['persentase_absensi'] }}%
                                                    </span>
                                                </div>

                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full"
                                                         style="width: {{ $siswa['persentase_absensi'] }}%">
                                                    </div>
                                                </div>

                                                <p class="text-xs text-gray-400 mt-2">
                                                    Hadir {{ $siswa['hadir'] }} / {{ $siswa['target_absensi'] }} hari efektif
                                                </p>

                                            </div>

                                            <div class="grid grid-cols-4 gap-2">

                                                <div class="bg-green-50 text-green-700 rounded-xl p-3 text-center">
                                                    <p class="text-xs">Hadir</p>
                                                    <h5 class="font-bold">{{ $siswa['hadir'] }}</h5>
                                                </div>

                                                <div class="bg-yellow-50 text-yellow-700 rounded-xl p-3 text-center">
                                                    <p class="text-xs">Izin</p>
                                                    <h5 class="font-bold">{{ $siswa['izin'] }}</h5>
                                                </div>

                                                <div class="bg-blue-50 text-blue-700 rounded-xl p-3 text-center">
                                                    <p class="text-xs">Sakit</p>
                                                    <h5 class="font-bold">{{ $siswa['sakit'] }}</h5>
                                                </div>

                                                <div class="bg-red-50 text-red-700 rounded-xl p-3 text-center">
                                                    <p class="text-xs">Alfa</p>
                                                    <h5 class="font-bold">{{ $siswa['alfa'] }}</h5>
                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                @empty

                                    <div class="col-span-1 md:col-span-2 text-center text-gray-500 py-12 bg-gray-50 rounded-2xl">
                                        Belum ada siswa di kelas ini.
                                    </div>

                                @endforelse

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-12 text-gray-500">
                Belum ada data rekap.
            </div>

        @endif

    </div>

</div>

<script>
    function openModalDetail(kelasId) {
        const modal = document.getElementById('modal-detail-' + kelasId);

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModalDetail(kelasId) {
        const modal = document.getElementById('modal-detail-' + kelasId);

        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id^="modal-detail-"]');

            modals.forEach(function (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });
</script>

@endsection
