@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F5F43] via-[#2F7D55] to-[#75C295] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-[#DDF3E7]/20 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-8">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-xs font-bold tracking-[0.2em] mb-5">
                    ADMIN MONITORING IBADAH
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Monitoring Sholat Fardhu
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Admin dapat menginput monitoring sholat fardhu untuk semua kelas.
                </p>
            </div>

            <a href="{{ route('admin.monitoring-sholat.riwayat') }}"
               class="bg-white text-[#2F7D55] px-6 py-3 rounded-2xl hover:bg-[#EEF7F1] transition font-bold">
                Lihat Riwayat
            </a>

        </div>

    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

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

    <!-- FILTER -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Pilih Kelas & Tanggal
            </h2>

            <p class="text-gray-500 mt-1">
                Pilih kelas dan tanggal untuk menampilkan daftar siswa.
            </p>
        </div>

        <form method="GET"
              action="{{ route('admin.monitoring-sholat.index') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">

                    <option value="">
                        Semua Kelas
                    </option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ $kelasId == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
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
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F7D55] text-white px-6 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold shadow-sm">
                    Tampilkan Siswa
                </button>
            </div>

        </form>

    </div>

    <!-- FORM MONITORING -->
    <form method="POST"
          action="{{ route('admin.monitoring-sholat.store') }}"
          class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        @csrf

        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Checklist Sholat Siswa
                </h2>

                <p class="text-gray-500 mt-1">
                    Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                </p>
            </div>

        </div>

        @if ($siswas->count() > 0)

            <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

                <table class="w-full min-w-[1100px]">

                    <thead class="bg-[#4D9A72] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">
                                No
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                NIS
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Nama Siswa
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                <div>Subuh</div>
                                <input type="checkbox"
                                       onclick="checkColumn('subuh', this.checked)"
                                       class="mt-2 rounded">
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                <div>Dzuhur</div>
                                <input type="checkbox"
                                       onclick="checkColumn('dzuhur', this.checked)"
                                       class="mt-2 rounded">
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                <div>Ashar</div>
                                <input type="checkbox"
                                       onclick="checkColumn('ashar', this.checked)"
                                       class="mt-2 rounded">
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                <div>Maghrib</div>
                                <input type="checkbox"
                                       onclick="checkColumn('maghrib', this.checked)"
                                       class="mt-2 rounded">
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                <div>Isya</div>
                                <input type="checkbox"
                                       onclick="checkColumn('isya', this.checked)"
                                       class="mt-2 rounded">
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Keterangan
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @php
                            $no = 1;
                        @endphp

                        @foreach ($siswas as $namaKelas => $dataSiswa)

                            <tr>
                                <td colspan="9" class="bg-[#F8FBF9] px-6 py-4 font-bold text-[#1F252D]">
                                    Kelas {{ $namaKelas }}
                                </td>
                            </tr>

                            @foreach ($dataSiswa as $siswa)

                                @php
                                    $monitoring = $monitoringHariIni[$siswa->id] ?? null;
                                @endphp

                                <tr class="hover:bg-[#FAFCFB] transition">

                                    <td class="px-6 py-5 text-gray-700">
                                        {{ $no++ }}
                                    </td>

                                    <td class="px-6 py-5 text-gray-700 font-medium">
                                        {{ $siswa->nis }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">

                                            <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                            </div>

                                            <div>
                                                <h4 class="font-semibold text-[#1F252D]">
                                                    {{ $siswa->nama }}
                                                </h4>

                                                <p class="text-sm text-gray-400">
                                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                                </p>
                                            </div>

                                        </div>
                                    </td>

                                    <input type="hidden" name="siswa_ids[]" value="{{ $siswa->id }}">

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="subuh[{{ $siswa->id }}]"
                                               class="subuh w-5 h-5 rounded border-gray-300 text-[#2F7D55] focus:ring-[#4D9A72]"
                                               {{ $monitoring && $monitoring->subuh ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="dzuhur[{{ $siswa->id }}]"
                                               class="dzuhur w-5 h-5 rounded border-gray-300 text-[#2F7D55] focus:ring-[#4D9A72]"
                                               {{ $monitoring && $monitoring->dzuhur ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="ashar[{{ $siswa->id }}]"
                                               class="ashar w-5 h-5 rounded border-gray-300 text-[#2F7D55] focus:ring-[#4D9A72]"
                                               {{ $monitoring && $monitoring->ashar ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="maghrib[{{ $siswa->id }}]"
                                               class="maghrib w-5 h-5 rounded border-gray-300 text-[#2F7D55] focus:ring-[#4D9A72]"
                                               {{ $monitoring && $monitoring->maghrib ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <input type="checkbox"
                                               name="isya[{{ $siswa->id }}]"
                                               class="isya w-5 h-5 rounded border-gray-300 text-[#2F7D55] focus:ring-[#4D9A72]"
                                               {{ $monitoring && $monitoring->isya ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-6 py-5">
                                        <input type="text"
                                               name="keterangan[{{ $siswa->id }}]"
                                               value="{{ $monitoring->keterangan ?? '' }}"
                                               placeholder="Opsional"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72] bg-[#FAFCFB]">
                                    </td>

                                </tr>

                            @endforeach

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- TOMBOL SIMPAN CUMA SATU DI BAWAH -->
            <div class="flex justify-end mt-8">
                <button type="submit"
                        class="bg-[#2F7D55] text-white px-8 py-4 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Simpan Monitoring
                </button>
            </div>

        @else

            <div class="text-center py-16 bg-[#FAFCFB] rounded-[2rem] border border-dashed border-gray-200">
                <h3 class="text-xl font-bold text-[#1F252D]">
                    Belum Ada Data Siswa
                </h3>

                <p class="text-gray-500 mt-2">
                    Pilih kelas untuk menampilkan daftar siswa.
                </p>
            </div>

        @endif

    </form>

</div>

<script>
    function checkColumn(className, checked) {
        const checkboxes = document.querySelectorAll('.' + className);

        checkboxes.forEach(function (checkbox) {
            checkbox.checked = checked;
        });
    }
</script>

@endsection
