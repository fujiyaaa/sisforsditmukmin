@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="relative overflow-hidden bg-[#2F7D55] rounded-[2rem] shadow-sm p-8">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-white/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="inline-flex bg-white/15 text-white text-xs tracking-[0.25em] font-bold px-4 py-2 rounded-full mb-5">
                    RIWAYAT MONITORING IBADAH
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    Riwayat Monitoring Sholat
                </h1>

                <p class="text-white/90 mt-3 max-w-2xl">
                    Lihat data monitoring sholat siswa berdasarkan kalender.
                </p>
            </div>

            <a href="{{ route('monitoring-sholat.index') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] font-bold px-6 py-3 rounded-2xl transition">
                + Input Monitoring
            </a>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Filter Riwayat
            </h2>

            <p class="text-gray-500 mt-1">
                Pilih kelas, bulan, dan tahun untuk menampilkan riwayat monitoring.
            </p>
        </div>

        <form action="{{ route('monitoring-sholat.riwayat') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-5 gap-5">

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
                    Bulan
                </label>

                <select name="bulan"
                        class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    @foreach($daftarBulan as $nomorBulan => $namaBulan)
                        <option value="{{ $nomorBulan }}" {{ (int) $selectedBulan === (int) $nomorBulan ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Tahun
                </label>

                <select name="tahun"
                        class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                    @foreach($daftarTahun as $tahun)
                        <option value="{{ $tahun }}" {{ (int) $selectedTahun === (int) $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3.5 rounded-2xl font-bold transition">
                    Tampilkan
                </button>
            </div>

            <div class="flex items-end">
                <a href="{{ route('monitoring-sholat.riwayat') }}"
                   class="w-full text-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-3.5 rounded-2xl font-bold transition">
                    Reset
                </a>
            </div>

        </form>

    </div>

    {{-- KALENDER DAN DETAIL --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- KALENDER --}}
        <div class="xl:col-span-1 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Calendar {{ $daftarBulan[(int) $selectedBulan] }} {{ $selectedTahun }}
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

            @php
                $firstDay = \Carbon\Carbon::createFromDate($selectedTahun, $selectedBulan, 1);
                $startBlank = $firstDay->dayOfWeekIso - 1;
            @endphp

            <div class="grid grid-cols-7 gap-2">

                @for($i = 0; $i < $startBlank; $i++)
                    <div class="min-h-[84px]"></div>
                @endfor

                @foreach($calendarDays as $day)

                    @php
                        $dayClass = 'bg-gray-50 border-gray-100 hover:bg-gray-100';
                        $textClass = 'text-gray-700';
                        $smallText = 'kosong';

                        if ($day['total_data'] > 0 && $day['total_belum_lengkap'] == 0) {
                            $dayClass = 'bg-green-50 border-green-100 hover:bg-green-100';
                            $textClass = 'text-green-700';
                            $smallText = $day['total_data'] . ' data';
                        }

                        if ($day['total_data'] > 0 && $day['total_belum_lengkap'] > 0) {
                            $dayClass = 'bg-red-50 border-red-100 hover:bg-red-100';
                            $textClass = 'text-red-700';
                            $smallText = $day['total_data'] . ' data';
                        }

                        if ($day['is_selected']) {
                            $dayClass = 'bg-[#2F7D55] border-[#2F7D55] text-white shadow-md';
                            $textClass = 'text-white';
                            $smallText = $day['total_data'] > 0 ? $day['total_data'] . ' data' : 'kosong';
                        }
                    @endphp

                    <a href="{{ route('monitoring-sholat.riwayat', array_filter([
                            'kelas_id' => $kelas_id,
                            'bulan' => $selectedBulan,
                            'tahun' => $selectedTahun,
                            'tanggal' => $day['tanggal']
                        ])) }}"
                       class="relative min-h-[84px] rounded-2xl border p-3 transition {{ $dayClass }}">

                        <div class="flex items-center justify-between">
                            <span class="font-bold {{ $textClass }}">
                                {{ $day['hari'] }}
                            </span>

                            @if($day['is_today'])
                                <span class="w-2 h-2 rounded-full {{ $day['is_selected'] ? 'bg-white' : 'bg-[#2F7D55]' }}"></span>
                            @endif
                        </div>

                        <p class="text-[11px] mt-5 {{ $day['is_selected'] ? 'text-white/80' : 'text-gray-400' }}">
                            {{ $smallText }}
                        </p>

                    </a>

                @endforeach

            </div>

            <div class="flex flex-wrap gap-4 mt-6 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-lg bg-green-50 border border-green-100"></span>
                    <span class="text-gray-500">Lengkap</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-lg bg-red-50 border border-red-100"></span>
                    <span class="text-gray-500">Belum lengkap</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-lg bg-gray-50 border border-gray-100"></span>
                    <span class="text-gray-500">Kosong</span>
                </div>
            </div>

        </div>

        {{-- DETAIL TANGGAL --}}
        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

                <div>
                    <h2 class="text-2xl font-bold text-[#2F7D55]">
                        Detail Tanggal {{ \Carbon\Carbon::parse($selectedTanggal)->format('d-m-Y') }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Total data: {{ $riwayatTanggal->count() }} data monitoring
                    </p>
                </div>

                <a href="{{ route('monitoring-sholat.index', array_filter([
                    'kelas_id' => $kelas_id,
                    'tanggal' => $selectedTanggal
                ])) }}"
                   class="inline-flex items-center justify-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] font-bold px-6 py-3 rounded-2xl transition">
                    Input di Tanggal Ini
                </a>

            </div>

            @if($riwayatTanggal->count() > 0)

                <div class="overflow-x-auto rounded-[1.5rem] border border-gray-100">

                    <table class="w-full border-collapse min-w-[1000px]">

                        <thead>
                            <tr class="bg-[#4D9A72] text-white">
                                <th class="p-4 text-left whitespace-nowrap">NIS</th>
                                <th class="p-4 text-left whitespace-nowrap">Nama Siswa</th>
                                <th class="p-4 text-left whitespace-nowrap">Kelas</th>
                                <th class="p-4 text-center whitespace-nowrap">Subuh</th>
                                <th class="p-4 text-center whitespace-nowrap">Dzuhur</th>
                                <th class="p-4 text-center whitespace-nowrap">Ashar</th>
                                <th class="p-4 text-center whitespace-nowrap">Maghrib</th>
                                <th class="p-4 text-center whitespace-nowrap">Isya</th>
                                <th class="p-4 text-center whitespace-nowrap">Sumber</th>
                                <th class="p-4 text-left whitespace-nowrap">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($riwayatTanggal as $item)

                                <tr class="border-b border-gray-100 hover:bg-[#FAFCFB] transition">

                                    <td class="p-4 whitespace-nowrap">
                                        {{ $item->siswa->nis ?? '-' }}
                                    </td>

                                    <td class="p-4 font-semibold text-gray-800 whitespace-nowrap">
                                        {{ $item->siswa->nama ?? '-' }}
                                    </td>

                                    <td class="p-4 whitespace-nowrap">
                                        {{ $item->siswa->kelas->nama_kelas ?? '-' }}
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($item->subuh)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($item->dzuhur)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($item->ashar)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($item->maghrib)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($item->isya)
                                            <span class="text-green-600 font-bold text-lg">✓</span>
                                        @else
                                            <span class="text-red-500 font-bold text-lg">×</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-full text-sm font-semibold">
                                            {{ $item->sumber }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-gray-600 min-w-[220px]">
                                        {{ $item->keterangan ?: '-' }}
                                    </td>

                                </tr>

                            @endforeach
                        </tbody>

                    </table>

                </div>

            @else

                <div class="rounded-[1.5rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">

                    <h3 class="text-2xl font-bold text-gray-700">
                        Belum ada data monitoring
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Belum ada data monitoring pada tanggal ini.
                    </p>

                    <a href="{{ route('monitoring-sholat.index', array_filter([
                        'kelas_id' => $kelas_id,
                        'tanggal' => $selectedTanggal
                    ])) }}"
                       class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3 rounded-2xl font-bold transition mt-5">
                        Input Monitoring
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
