@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-[#2F6F4F]">
                    Monitoring Sholat Fardhu
                </h1>

                <p class="text-gray-500 mt-2">
                    Pilih kelas dan tanggal, lalu checklist sholat fardhu siswa.
                </p>
            </div>

            <a href="{{ route('monitoring-sholat.riwayat') }}"
               class="bg-white border border-[#4D9A72] text-[#2F6F4F] px-6 py-3 rounded-2xl hover:bg-[#F0F8F4] transition text-center">
                Lihat Riwayat
            </a>

        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl shadow-lg p-8">

        <form action="{{ route('monitoring-sholat.index') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Pilih Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <option value="">-- Pilih Kelas --</option>

                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>
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
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition">
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
                    title: '<strong>Berhasil Disimpan</strong>',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#28a745',
                    timer: 3500,
                    timerProgressBar: true,
                    position: 'center',
                    width: '500px',
                    padding: '2.5rem',
                    backdrop: `
                        rgba(0,0,0,0.6)
                    `
                });
            });
        </script>
    @endif

    <!-- DATA CHECKLIST -->
    @if($kelas_id)

        <form action="{{ route('monitoring-sholat.store') }}" method="POST">
            @csrf

            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="bg-white rounded-3xl shadow-lg p-8">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                    <div>
                        <h2 class="text-2xl font-bold text-[#2F6F4F]">
                            Checklist Sholat Siswa
                        </h2>

                        <p class="text-gray-500 mt-1">
                            Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                        </p>
                    </div>

                    <button type="submit"
                            class="bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition">
                        Simpan Monitoring
                    </button>

                </div>

                <div class="overflow-x-auto rounded-2xl border border-gray-100">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-[#4D9A72] text-white">
                                <th class="p-4 text-left">No</th>
                                <th class="p-4 text-left">NIS</th>
                                <th class="p-4 text-left min-w-[180px]">Nama Siswa</th>

                                <th class="p-4 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Subuh</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="subuh">
                                    </div>
                                </th>

                                <th class="p-4 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Dzuhur</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="dzuhur">
                                    </div>
                                </th>

                                <th class="p-4 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Ashar</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="ashar">
                                    </div>
                                </th>

                                <th class="p-4 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Maghrib</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="maghrib">
                                    </div>
                                </th>

                                <th class="p-4 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span>Isya</span>
                                        <input type="checkbox"
                                               class="check-all w-4 h-4 accent-white cursor-pointer"
                                               data-target="isya">
                                    </div>
                                </th>

                                <th class="p-4 text-left min-w-[220px]">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($siswas as $siswa)

                                @php
                                    $data = $monitoring[$siswa->id] ?? null;
                                @endphp

                                <tr class="border-b hover:bg-[#F7FBF9] transition">

                                    <td class="p-4 text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="p-4 text-gray-700">
                                        {{ $siswa->nis }}
                                    </td>

                                    <td class="p-4 font-semibold text-gray-800">
                                        {{ $siswa->nama }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][subuh]"
                                               value="1"
                                               class="subuh w-5 h-5 accent-[#4D9A72] cursor-pointer"
                                               {{ $data && $data->subuh ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][dzuhur]"
                                               value="1"
                                               class="dzuhur w-5 h-5 accent-[#4D9A72] cursor-pointer"
                                               {{ $data && $data->dzuhur ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][ashar]"
                                               value="1"
                                               class="ashar w-5 h-5 accent-[#4D9A72] cursor-pointer"
                                               {{ $data && $data->ashar ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][maghrib]"
                                               value="1"
                                               class="maghrib w-5 h-5 accent-[#4D9A72] cursor-pointer"
                                               {{ $data && $data->maghrib ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4 text-center">
                                        <input type="checkbox"
                                               name="sholat[{{ $siswa->id }}][isya]"
                                               value="1"
                                               class="isya w-5 h-5 accent-[#4D9A72] cursor-pointer"
                                               {{ $data && $data->isya ? 'checked' : '' }}>
                                    </td>

                                    <td class="p-4">
                                        <input type="text"
                                               name="sholat[{{ $siswa->id }}][keterangan]"
                                               value="{{ $data->keterangan ?? '' }}"
                                               placeholder="Opsional"
                                               class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="9" class="p-10 text-center text-gray-500">
                                        Belum ada siswa di kelas ini.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </form>

    @else

        <div class="bg-white rounded-3xl shadow-lg p-10 text-center">

            <div class="text-5xl mb-4">
                📋
            </div>

            <h2 class="text-2xl font-bold text-gray-700">
                Pilih kelas terlebih dahulu
            </h2>

            <p class="text-gray-500 mt-2">
                Setelah kelas dipilih, daftar siswa akan muncul untuk checklist sholat.
            </p>

        </div>

    @endif

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
