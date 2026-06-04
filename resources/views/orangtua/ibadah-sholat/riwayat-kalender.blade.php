@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-8">

    <div class="bg-white rounded-3xl shadow-md p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-[#1F252D]">
                    Riwayat Monitoring Sholat Fardhu
                </h1>

                <p class="text-gray-500 mt-2">
                    Kalender riwayat sholat fardhu {{ $siswa->nama }}.
                </p>
            </div>

            <a href="{{ url('/orangtua/ibadah-sholat') }}"
               class="bg-gray-100 text-gray-700 px-5 py-3 rounded-2xl hover:bg-gray-200 transition text-center">
                Kembali
            </a>

        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-md p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <a href="{{ route('orangtua.ibadah-sholat.riwayat', ['bulan' => $bulanSebelumnya]) }}"
               class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-xl font-semibold hover:bg-[#DDF3E7] transition text-center">
                ← Bulan Sebelumnya
            </a>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    {{ $tanggalAwal->translatedFormat('F Y') }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Klik tanggal untuk melihat rekapan sholat.
                </p>
            </div>

            <a href="{{ route('orangtua.ibadah-sholat.riwayat', ['bulan' => $bulanBerikutnya]) }}"
               class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-xl font-semibold hover:bg-[#DDF3E7] transition text-center">
                Bulan Berikutnya →
            </a>

        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-md p-6">
        <div class="flex flex-wrap gap-5 text-sm">

            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-green-500"></span>
                <span class="text-gray-600">Lengkap 5 waktu</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-red-500"></span>
                <span class="text-gray-600">Belum lengkap</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-gray-300"></span>
                <span class="text-gray-600">Belum ada data</span>
            </div>

        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-md p-8">

        <div class="grid grid-cols-7 gap-3 mb-4 text-center font-bold text-gray-600">
            <div>Min</div>
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>
        </div>

        <div class="grid grid-cols-7 gap-3">

            @for ($i = 0; $i < $tanggalAwal->dayOfWeek; $i++)
                <div></div>
            @endfor

            @foreach ($hariDalamBulan as $hari)

                @php
                    $bgClass = 'bg-gray-100 text-gray-500 border-gray-200';

                    if ($hari['status'] == 'lengkap') {
                        $bgClass = 'bg-green-100 text-green-700 border-green-300';
                    } elseif ($hari['status'] == 'belum_lengkap') {
                        $bgClass = 'bg-red-100 text-red-700 border-red-300';
                    }

                    $modalId = 'modal-' . $hari['key'];
                @endphp

                <button type="button"
                        onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden')"
                        class="min-h-[95px] rounded-2xl border p-3 text-left hover:shadow-md transition {{ $bgClass }}">

                    <div class="font-bold text-lg">
                        {{ $hari['tanggal']->format('d') }}
                    </div>

                    @if ($hari['status'] == 'lengkap')
                        <div class="text-xs mt-2 font-semibold">
                            Lengkap
                        </div>
                    @elseif ($hari['status'] == 'belum_lengkap')
                        <div class="text-xs mt-2 font-semibold">
                            {{ $hari['jumlahSholat'] }}/5 Sholat
                        </div>
                    @else
                        <div class="text-xs mt-2">
                            Belum ada data
                        </div>
                    @endif

                </button>

                <div id="{{ $modalId }}"
                     class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center px-4">

                    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg p-8 relative max-h-[90vh] overflow-y-auto">

                        <button type="button"
                                onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">
                            ×
                        </button>

                        <h3 class="text-2xl font-bold text-[#1F252D] mb-2">
                            Rekapan Sholat
                        </h3>

                        <p class="text-gray-500 mb-6">
                            {{ $hari['tanggal']->translatedFormat('l, d F Y') }}
                        </p>

                        @if ($hari['rekap'])

                            <div class="mb-6 border rounded-2xl p-5">

                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-bold text-[#1F252D]">
                                        Hasil Rekapan
                                    </h4>

                                    <span class="text-sm text-gray-400">
                                        {{ $hari['jumlahSholat'] }}/5 Sholat
                                    </span>
                                </div>

                                <div class="space-y-3">

                                    <div class="flex justify-between items-center border rounded-xl px-4 py-3">
                                        <span>Subuh</span>
                                        <span class="{{ $hari['rekap']['subuh'] ? 'text-green-600' : 'text-red-600' }} font-bold">
                                            {{ $hari['rekap']['subuh'] ? 'Sudah' : 'Belum' }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center border rounded-xl px-4 py-3">
                                        <span>Dzuhur</span>
                                        <span class="{{ $hari['rekap']['dzuhur'] ? 'text-green-600' : 'text-red-600' }} font-bold">
                                            {{ $hari['rekap']['dzuhur'] ? 'Sudah' : 'Belum' }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center border rounded-xl px-4 py-3">
                                        <span>Ashar</span>
                                        <span class="{{ $hari['rekap']['ashar'] ? 'text-green-600' : 'text-red-600' }} font-bold">
                                            {{ $hari['rekap']['ashar'] ? 'Sudah' : 'Belum' }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center border rounded-xl px-4 py-3">
                                        <span>Maghrib</span>
                                        <span class="{{ $hari['rekap']['maghrib'] ? 'text-green-600' : 'text-red-600' }} font-bold">
                                            {{ $hari['rekap']['maghrib'] ? 'Sudah' : 'Belum' }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center border rounded-xl px-4 py-3">
                                        <span>Isya</span>
                                        <span class="{{ $hari['rekap']['isya'] ? 'text-green-600' : 'text-red-600' }} font-bold">
                                            {{ $hari['rekap']['isya'] ? 'Sudah' : 'Belum' }}
                                        </span>
                                    </div>

                                </div>

                                @if ($hari['status'] == 'lengkap')
                                    <div class="mt-6 bg-green-100 text-green-700 rounded-2xl p-4 font-semibold text-center">
                                        Sholat lengkap 5 waktu.
                                    </div>
                                @else
                                    <div class="mt-6 bg-red-100 text-red-700 rounded-2xl p-4 font-semibold text-center">
                                        Sholat belum lengkap.
                                    </div>
                                @endif

                            </div>

                        @else

                            <div class="bg-gray-100 rounded-2xl p-6 text-center text-gray-500">
                                Belum ada data monitoring sholat pada tanggal ini.
                            </div>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection
