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
                    RIWAYAT MONITORING IBADAH
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Riwayat Monitoring Sholat
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Lihat data monitoring sholat dengan tampilan kalender agar lebih mudah dibaca.
                </p>
            </div>

            <a href="{{ route('admin.monitoring-sholat.index') }}"
               class="bg-white text-[#2F7D55] px-6 py-3 rounded-2xl hover:bg-[#EEF7F1] transition font-bold">
                + Input Monitoring
            </a>

        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Filter Riwayat
            </h2>

            <p class="text-gray-500 mt-1">
                Pilih kelas, bulan, dan tahun untuk menampilkan riwayat monitoring.
            </p>
        </div>

        <form method="GET"
              action="{{ route('admin.monitoring-sholat.riwayat') }}"
              class="grid grid-cols-1 md:grid-cols-5 gap-5">

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

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
                    Bulan
                </label>

                <select name="bulan"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    @foreach ($daftarBulan as $key => $namaBulan)
                        <option value="{{ $key }}" {{ $bulanAngka == $key ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Tahun
                </label>

                <select name="tahun"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    @foreach ($daftarTahun as $itemTahun)
                        <option value="{{ $itemTahun }}" {{ $tahun == $itemTahun ? 'selected' : '' }}>
                            {{ $itemTahun }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="md:col-span-2 flex items-end gap-3">

                <button type="submit"
                        class="w-full bg-[#2F7D55] text-white px-6 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Tampilkan
                </button>

                <a href="{{ route('admin.monitoring-sholat.riwayat') }}"
                   class="w-full text-center bg-[#EEF7F1] text-[#2F7D55] px-6 py-3 rounded-2xl hover:bg-[#DDF3E7] transition font-bold">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <!-- KALENDER + DETAIL -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- KALENDER -->
        <div class="xl:col-span-1 bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

            <div class="mb-6">

                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Kalender {{ $daftarBulan[$bulanAngka] }} {{ $tahun }}
                </h2>

                <p class="text-gray-500 mt-1">
                    Klik tanggal untuk melihat detail monitoring.
                </p>

            </div>

            <div class="grid grid-cols-7 gap-2 mb-3 text-center text-sm font-bold text-gray-500">
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div>Sab</div>
                <div>Min</div>
            </div>

            <div class="grid grid-cols-7 gap-2">

                @for ($i = 0; $i < $paddingAwalKalender; $i++)
                    <div class="h-20 rounded-2xl bg-transparent"></div>
                @endfor

                @foreach ($kalender as $hari)

                    @php
                        $queryTanggal = request()->query();
                        $queryTanggal['tanggal'] = $hari['tanggal'];
                    @endphp

                    <a href="{{ route('admin.monitoring-sholat.riwayat', $queryTanggal) }}"
                       class="h-20 rounded-2xl border transition p-2 flex flex-col justify-between
                       {{ $hari['is_selected'] ? 'bg-[#2F7D55] border-[#2F7D55] text-white shadow-md' : 'bg-[#FAFCFB] border-gray-100 hover:bg-[#EEF7F1]' }}">

                        <div class="flex items-center justify-between">
                            <span class="font-bold {{ $hari['is_selected'] ? 'text-white' : 'text-[#1F252D]' }}">
                                {{ $hari['hari'] }}
                            </span>

                            @if ($hari['is_today'])
                                <span class="w-2 h-2 rounded-full {{ $hari['is_selected'] ? 'bg-white' : 'bg-[#4D9A72]' }}"></span>
                            @endif
                        </div>

                        @if ($hari['total'] > 0)
                            <div class="text-xs">
                                <div class="inline-flex items-center justify-center px-2 py-1 rounded-xl font-bold
                                    {{ $hari['is_selected'] ? 'bg-white text-[#2F7D55]' : 'bg-[#DDF3E7] text-[#2F7D55]' }}">
                                    {{ $hari['total'] }} data
                                </div>
                            </div>
                        @else
                            <div class="text-xs {{ $hari['is_selected'] ? 'text-white/70' : 'text-gray-300' }}">
                                kosong
                            </div>
                        @endif

                    </a>

                @endforeach

            </div>

            <div class="mt-6 bg-[#F8FBF9] border border-gray-100 rounded-3xl p-5">
                <p class="text-sm text-gray-500">
                    Tanggal dengan data terbanyak
                </p>

                <h3 class="text-xl font-bold text-[#2F7D55] mt-1">
                    @if ($tanggalTerbanyak && $tanggalTerbanyak['total'] > 0)
                        {{ \Carbon\Carbon::parse($tanggalTerbanyak['tanggal'])->format('d-m-Y') }}
                    @else
                        -
                    @endif
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                    {{ $tanggalTerbanyak['total'] ?? 0 }} data monitoring
                </p>
            </div>

        </div>

        <!-- DETAIL TANGGAL -->
        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div>
                    <h2 class="text-2xl font-bold text-[#2F7D55]">
                        Detail Tanggal {{ \Carbon\Carbon::parse($tanggalDipilih)->format('d-m-Y') }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Total data: {{ $detailTanggal->count() }} data monitoring
                    </p>
                </div>

                <a href="{{ route('admin.monitoring-sholat.index', ['tanggal' => $tanggalDipilih, 'kelas_id' => $kelasId]) }}"
                   class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl hover:bg-[#DDF3E7] transition font-bold">
                    Input di Tanggal Ini
                </a>

            </div>

            @if ($detailTanggal->count() > 0)

                <div class="overflow-x-auto rounded-2xl border border-gray-100">

                    <table class="w-full min-w-[1000px]">

                        <thead class="bg-[#4D9A72] text-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">
                                    NIS
                                </th>

                                <th class="px-6 py-4 text-left font-semibold">
                                    Nama Siswa
                                </th>

                                <th class="px-6 py-4 text-left font-semibold">
                                    Kelas
                                </th>

                                <th class="px-6 py-4 text-center font-semibold">
                                    Subuh
                                </th>

                                <th class="px-6 py-4 text-center font-semibold">
                                    Dzuhur
                                </th>

                                <th class="px-6 py-4 text-center font-semibold">
                                    Ashar
                                </th>

                                <th class="px-6 py-4 text-center font-semibold">
                                    Maghrib
                                </th>

                                <th class="px-6 py-4 text-center font-semibold">
                                    Isya
                                </th>

                                <th class="px-6 py-4 text-center font-semibold">
                                    Sumber
                                </th>

                                <th class="px-6 py-4 text-left font-semibold">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">

                            @foreach ($detailTanggal as $item)

                                <tr class="hover:bg-[#FAFCFB] transition">

                                    <td class="px-6 py-5 text-gray-700">
                                        {{ $item->siswa->nis ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5 font-semibold text-[#1F252D]">
                                        {{ $item->siswa->nama ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5 text-gray-700">
                                        {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($item->subuh)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($item->dzuhur)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($item->ashar)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($item->maghrib)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($item->isya)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($item->sumber == 'orangtua')
                                            <span class="bg-[#DDF3E7] text-[#2F7D55] px-4 py-2 rounded-2xl font-semibold text-sm">
                                                Orang Tua
                                            </span>
                                        @elseif ($item->sumber == 'admin')
                                            <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-2xl font-semibold text-sm">
                                                Admin
                                            </span>
                                        @else
                                            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-2xl font-semibold text-sm">
                                                Guru
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-16 bg-[#FAFCFB] rounded-[2rem] border border-dashed border-gray-200">
                    <h3 class="text-xl font-bold text-[#1F252D]">
                        Tidak Ada Data di Tanggal Ini
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Pilih tanggal lain pada kalender atau input monitoring baru.
                    </p>
                </div>

            @endif

        </div>

    </div>

</div>

@endsection
