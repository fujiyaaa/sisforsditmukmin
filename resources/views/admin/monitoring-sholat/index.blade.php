@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="relative overflow-hidden bg-[#2F7D55] rounded-[2rem] shadow-sm p-8">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-white/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="inline-flex bg-white/15 text-white text-xs tracking-[0.25em] font-bold px-4 py-2 rounded-full mb-5">
                    ADMIN MONITORING IBADAH
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    Monitoring Sholat Fardhu
                </h1>

                <p class="text-white/90 mt-3 max-w-2xl">
                    Admin dapat menginput monitoring sholat fardhu siswa berdasarkan kelas dan tanggal.
                </p>
            </div>

            <a href="{{ route('admin.monitoring-sholat.riwayat') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] font-bold px-6 py-3 rounded-2xl transition">
                Lihat Riwayat
            </a>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Pilih Kelas & Tanggal
            </h2>

            <p class="text-gray-500 mt-1">
                Pilih kelas dan tanggal untuk menampilkan daftar siswa.
            </p>
        </div>

        <form action="{{ route('admin.monitoring-sholat.index') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
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
    <form action="{{ route('admin.monitoring-sholat.store') }}" method="POST">
        @csrf

        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-7">

                <div>
                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Checklist Sholat Siswa
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

                                <th class="p-4 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Subuh</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="subuh">
                                    </div>
                                </th>

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

                                <th class="p-4 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Maghrib</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="maghrib">
                                    </div>
                                </th>

                                <th class="p-4 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Isya</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="isya">
                                    </div>
                                </th>

                                <th class="p-4 text-left whitespace-nowrap">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp

                            @foreach($siswas as $namaKelas => $daftarSiswa)

                                <tr>
                                    <td colspan="9" class="px-5 py-4 bg-[#F6FAF8] text-[#1F252D] font-bold border-b border-gray-100">
                                        Kelas {{ $namaKelas }}
                                    </td>
                                </tr>

                                @foreach($daftarSiswa as $siswa)

                                    @php
                                        $data = $monitoringHariIni[$siswa->id] ?? null;
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
                                            <input type="hidden" name="siswa_ids[]" value="{{ $siswa->id }}">

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

                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][subuh]"
                                                   value="1"
                                                   class="subuh w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->subuh ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][dzuhur]"
                                                   value="1"
                                                   class="dzuhur w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->dzuhur ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][ashar]"
                                                   value="1"
                                                   class="ashar w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->ashar ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][maghrib]"
                                                   value="1"
                                                   class="maghrib w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->maghrib ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-4 text-center">
                                            <input type="checkbox"
                                                   name="sholat[{{ $siswa->id }}][isya]"
                                                   value="1"
                                                   class="isya w-5 h-5 accent-[#2F7D55] cursor-pointer rounded"
                                                   {{ $data && $data->isya ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-4">
                                            <input type="text"
                                                   name="keterangan[{{ $siswa->id }}]"
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
