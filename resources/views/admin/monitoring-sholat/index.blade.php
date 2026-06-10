@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    {{-- HERO HEADER --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    ADMIN MONITORING IBADAH
                </div>

                <h1 class="text-4xl font-bold">
                    Monitoring Sholat Fardhu
                </h1>

                <p class="text-white/80 mt-2 max-w-2xl">
                    Admin dapat menginput monitoring sholat fardhu siswa berdasarkan kelas dan tanggal.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[260px] border border-white/10">
                <p class="text-sm text-white/70">
                    Tanggal Aktif
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}
                </h2>

                <p class="text-white/80 text-sm mt-1">
                    Monitoring Sholat Fardhu
                </p>

                <a href="{{ route('admin.monitoring-sholat.riwayat') }}"
                   class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                    Lihat Riwayat
                </a>
            </div>

        </div>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-[#EEF7F1] border border-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl">

            <p class="font-bold mb-2">
                Data belum sesuai:
            </p>

            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- FILTER --}}
    <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Monitoring
                </h2>

                <p class="text-gray-500 mt-1">
                    Pilih kelas dan tanggal untuk menampilkan daftar siswa.
                </p>
            </div>

            <a href="{{ route('admin.monitoring-sholat.index') }}"
               class="bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl hover:bg-gray-200 transition text-center font-semibold">
                Reset Filter
            </a>

        </div>

        <form action="{{ route('admin.monitoring-sholat.index') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                    <option value="">
                        Semua Kelas
                    </option>

                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ $tanggal }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition font-semibold">
                    Tampilkan
                </button>
            </div>

            <div class="flex items-end">
                <div class="w-full bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold text-center">
                    {{ $siswas->flatten()->count() }} Siswa
                </div>
            </div>

        </form>

        <div class="mt-6 bg-[#EEF7F1] border border-gray-100 rounded-2xl p-5">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                <div>
                    <p class="font-bold text-[#2F7D55]">
                        Monitoring Sholat Fardhu
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Checklist sholat = Subuh, Dzuhur, Ashar, Maghrib, dan Isya untuk setiap siswa.
                    </p>
                </div>

                <div class="bg-white text-[#2F7D55] px-4 py-2 rounded-2xl font-bold text-sm tracking-wide">
                    SHOLAT
                </div>

            </div>

        </div>

    </div>

    {{-- FORM INPUT --}}
    <form action="{{ route('admin.monitoring-sholat.store') }}"
          method="POST"
          class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">
        @csrf

        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Checklist Sholat Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}
                </p>
            </div>

            @if($siswas->count() > 0)
                <button type="submit"
                        class="bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition font-semibold">
                    Simpan Monitoring
                </button>
            @endif

        </div>

        @if($siswas->count() > 0)

            <div class="overflow-x-auto rounded-3xl border border-gray-100">

                <table class="w-full min-w-[1100px]">

                    <thead class="bg-[#4D9A72] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">No</th>
                            <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">NIS</th>
                            <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Nama Siswa</th>

                            <th class="px-6 py-4 text-center font-semibold whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    <span>Subuh</span>
                                    <input type="checkbox"
                                           class="check-all w-4 h-4 accent-white cursor-pointer"
                                           data-target="subuh">
                                </div>
                            </th>

                            <th class="px-6 py-4 text-center font-semibold whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    <span>Dzuhur</span>
                                    <input type="checkbox"
                                           class="check-all w-4 h-4 accent-white cursor-pointer"
                                           data-target="dzuhur">
                                </div>
                            </th>

                            <th class="px-6 py-4 text-center font-semibold whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    <span>Ashar</span>
                                    <input type="checkbox"
                                           class="check-all w-4 h-4 accent-white cursor-pointer"
                                           data-target="ashar">
                                </div>
                            </th>

                            <th class="px-6 py-4 text-center font-semibold whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    <span>Maghrib</span>
                                    <input type="checkbox"
                                           class="check-all w-4 h-4 accent-white cursor-pointer"
                                           data-target="maghrib">
                                </div>
                            </th>

                            <th class="px-6 py-4 text-center font-semibold whitespace-nowrap">
                                <div class="flex flex-col items-center gap-2">
                                    <span>Isya</span>
                                    <input type="checkbox"
                                           class="check-all w-4 h-4 accent-white cursor-pointer"
                                           data-target="isya">
                                </div>
                            </th>

                            <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @php
                            $nomor = 1;
                        @endphp

                        @foreach($siswas as $namaKelas => $daftarSiswa)

                            <tr>
                                <td colspan="9" class="px-6 py-4 bg-[#F8FBF9] text-[#1F252D] font-bold border-b border-gray-100">
                                    Kelas {{ $namaKelas }}
                                </td>
                            </tr>

                            @foreach($daftarSiswa as $siswa)

                                @php
                                    $data = $monitoringHariIni[$siswa->id] ?? null;
                                    $inisial = strtoupper(substr($siswa->nama ?? '-', 0, 1));
                                @endphp

                                <tr class="hover:bg-[#F8FBF9] transition">

                                    <td class="px-6 py-5 text-gray-600 whitespace-nowrap">
                                        {{ $nomor++ }}
                                    </td>

                                    <td class="px-6 py-5 text-gray-700 font-medium whitespace-nowrap">
                                        {{ $siswa->nis }}
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">

                                        <input type="hidden" name="siswa_ids[]" value="{{ $siswa->id }}">

                                        <div class="flex items-center gap-4">

                                            <div class="w-12 h-12 rounded-full bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-lg">
                                                {{ $inisial }}
                                            </div>

                                            <div>
                                                <p class="font-bold text-[#1F252D]">
                                                    {{ $siswa->nama }}
                                                </p>

                                                <p class="text-sm text-gray-400 mt-1">
                                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][subuh]"
                                               value="1"
                                               class="subuh w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                               {{ $data && $data->subuh ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][dzuhur]"
                                               value="1"
                                               class="dzuhur w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                               {{ $data && $data->dzuhur ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][ashar]"
                                               value="1"
                                               class="ashar w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                               {{ $data && $data->ashar ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][maghrib]"
                                               value="1"
                                               class="maghrib w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                               {{ $data && $data->maghrib ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][isya]"
                                               value="1"
                                               class="isya w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                               {{ $data && $data->isya ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5">
                                        <input type="text"
                                               name="keterangan[{{ $siswa->id }}]"
                                               value="{{ $data->keterangan ?? '' }}"
                                               placeholder="Opsional"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-white">
                                    </td>

                                </tr>

                            @endforeach

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-16 bg-[#F8FBF9] rounded-3xl border border-dashed border-gray-200">

                <div class="w-16 h-16 mx-auto rounded-full bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                    0
                </div>

                <h3 class="text-xl font-bold text-[#1F252D]">
                    Belum Ada Data Siswa
                </h3>

                <p class="text-gray-500 mt-2">
                    Pilih kelas terlebih dahulu untuk menampilkan daftar siswa.
                </p>

            </div>

        @endif

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAllBoxes = document.querySelectorAll('.check-all');

        checkAllBoxes.forEach(function (checkAll) {
            checkAll.addEventListener('change', function () {
                const targetClass = this.getAttribute('data-target');
                const checkboxes = document.querySelectorAll('input.' + targetClass);

                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = checkAll.checked;
                });
            });
        });
    });
</script>

@endsection