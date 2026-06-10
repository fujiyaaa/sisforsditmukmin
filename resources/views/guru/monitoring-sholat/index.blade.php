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
                GURU MONITORING IBADAH
            </div>

            <h1 class="text-4xl font-bold">
                Monitoring Sholat Fardhu
            </h1>

            <p class="text-white/80 mt-2 max-w-2xl">
                Input monitoring sholat fardhu siswa berdasarkan kelas dan tanggal yang dipilih.
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

            <a href="{{ route('monitoring-sholat.riwayat') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-4 py-2 rounded-2xl font-semibold text-sm mt-4 transition">
                Lihat Riwayat
            </a>
        </div>

    </div>

</div>
    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Daftar Kelas
            </h2>

        </div>

        <form action="{{ route('monitoring-sholat.index') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    <option value="">Semua Kelas</option>

                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ $tanggal }}"
                       class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3.5 rounded-2xl font-bold transition">
                    Tampilkan Siswa
                </button>
            </div>

        </form>

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

    {{-- FORM INPUT --}}
    <form action="{{ route('monitoring-sholat.store') }}" method="POST">
        @csrf

        <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-7">

                <div>
                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Monitoring Sholat Fardhu
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                    </p>
                </div>

                <button type="submit"
                        class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3 rounded-2xl font-bold transition">
                    Simpan Monitoring
                </button>

            </div>



            @if($siswas->count() > 0)

                <div class="overflow-x-auto rounded-[1.5rem] border border-gray-100">

                    <table class="w-full border-collapse min-w-[1100px]">

                        <thead>
                            <tr class="bg-[#4D9A72] text-white">
                                <th class="p-4 text-left whitespace-nowrap">No</th>
                                <th class="p-4 text-left whitespace-nowrap">NIS</th>
                                <th class="p-4 text-left whitespace-nowrap">Nama Siswa</th>

                                <th class="p-4 text-center whitespace-nowrap">Subuh</th>

                                <th class="p-4 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Dzuhur</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="dzuhur">
                                    </div>
                                </th>

                                <th class="p-4 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Ashar</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="ashar">
                                    </div>
                                </th>

                                <th class="p-4 text-center whitespace-nowrap">Maghrib</th>
                                <th class="p-4 text-center whitespace-nowrap">Isya</th>
                                <th class="p-4 text-left whitespace-nowrap">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp

                            @foreach($siswasByKelas as $namaKelas => $daftarSiswa)

                                <tr>
                                    <td colspan="9" class="px-5 py-4 bg-[#F6FAF8] text-[#1F252D] font-bold border-b border-gray-100">
                                        Kelas {{ $namaKelas }}
                                    </td>
                                </tr>

                                @foreach($daftarSiswa as $siswa)

                                    @php
                                        $data = $monitoring[$siswa->id] ?? null;
                                        $inisial = strtoupper(substr($siswa->nama ?? '-', 0, 1));
                                    @endphp

                                    <tr class="border-b border-gray-100 hover:bg-[#FAFCFB] transition">

                                        <td class="p-4 text-gray-600 whitespace-nowrap">
                                            {{ $nomor++ }}
                                        </td>

                                        <td class="p-4 text-gray-700 whitespace-nowrap">
                                            {{ $siswa->nis }}
                                        </td>

                                        <td class="p-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                                    {{ $inisial }}
                                                </div>

                                                <div>
                                                    <p class="font-bold text-[#1F252D]">
                                                        {{ $siswa->nama }}
                                                    </p>

                                                    <p class="text-xs text-gray-400">
                                                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- SUBUH DISABLED --}}
                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   disabled
                                                   class="w-5 h-5 accent-[#2F7D55] cursor-not-allowed rounded opacity-40"
                                                   {{ $data && $data->subuh ? 'checked' : '' }}>
                                        </td>

                                        {{-- DZUHUR AKTIF --}}
                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][dzuhur]"
                                                   value="1"
                                                   class="dzuhur w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->dzuhur ? 'checked' : '' }}>
                                        </td>

                                        {{-- ASHAR AKTIF --}}
                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][ashar]"
                                                   value="1"
                                                   class="ashar w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->ashar ? 'checked' : '' }}>
                                        </td>

                                        {{-- MAGHRIB DISABLED --}}
                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   disabled
                                                   class="w-5 h-5 accent-[#2F7D55] cursor-not-allowed rounded opacity-40"
                                                   {{ $data && $data->maghrib ? 'checked' : '' }}>
                                        </td>

                                        {{-- ISYA DISABLED --}}
                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   disabled
                                                   class="w-5 h-5 accent-[#2F7D55] cursor-not-allowed rounded opacity-40"
                                                   {{ $data && $data->isya ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-4">
                                            <input type="text"
                                                   name="sholat[{{ $siswa->id }}][keterangan]"
                                                   value="{{ $data->keterangan ?? '' }}"
                                                   placeholder="Opsional"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                        </td>

                                    </tr>

                                @endforeach

                            @endforeach
                        </tbody>

                    </table>

                </div>

            @else

                <div class="rounded-[1.5rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">

                    <h3 class="text-2xl font-bold text-gray-700">
                        Belum ada siswa
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Belum ada siswa yang dapat ditampilkan.
                    </p>

                </div>

            @endif

        </div>
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
