@extends('layoutsOrtu.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>
            <h1 class="text-3xl font-bold text-[#1F252D]">
                Riwayat Monitoring Sholat Fardhu
            </h1>

            <p class="text-gray-500 mt-2">
                Kalender riwayat sholat fardhu {{ $siswa->nama ?? '-' }}.
            </p>
        </div>

        <a href="{{ route('orangtua.ibadah-sholat.index') }}"
           class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-[#1F252D] px-6 py-3 rounded-2xl font-bold transition">
            Kembali
        </a>

    </div>

    {{-- NAVIGASI BULAN --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <a href="{{ route('orangtua.ibadah-sholat.riwayat', ['bulan' => $bulanSebelumnya]) }}"
               class="inline-flex items-center justify-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-3 rounded-2xl font-bold transition">
                ← Bulan Sebelumnya
            </a>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    {{ $tanggalAwal->translatedFormat('F Y') }}
                </h2>

                <p class="text-gray-500 mt-1">
                    Klik tanggal untuk melihat detail sholat.
                </p>
            </div>

            <a href="{{ route('orangtua.ibadah-sholat.riwayat', ['bulan' => $bulanBerikutnya]) }}"
               class="inline-flex items-center justify-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-3 rounded-2xl font-bold transition">
                Bulan Berikutnya →
            </a>

        </div>

    </div>

    {{-- LEGENDA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-5">

        <div class="flex flex-wrap gap-5 text-sm">

            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-green-600"></span>
                <span class="text-gray-600">Lengkap 5 waktu</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-red-600"></span>
                <span class="text-gray-600">Belum lengkap</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-gray-300"></span>
                <span class="text-gray-600">Belum ada data</span>
            </div>

        </div>

    </div>

    {{-- KALENDER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="grid grid-cols-7 gap-3 mb-4 text-center font-bold text-[#1F252D]">
            <div>Min</div>
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>
        </div>

        @php
            $paddingAwal = $tanggalAwal->dayOfWeek;
        @endphp

        <div class="grid grid-cols-7 gap-3">

            @for($i = 0; $i < $paddingAwal; $i++)
                <div class="min-h-[92px]"></div>
            @endfor

            @foreach($hariDalamBulan as $hari)

                @php
                    $cardClass = 'bg-gray-50 border-gray-100 hover:bg-gray-100';
                    $textClass = 'text-gray-500';
                    $statusText = 'Belum ada data';

                    if ($hari['status'] === 'lengkap') {
                        $cardClass = 'bg-green-50 border-green-200 hover:bg-green-100';
                        $textClass = 'text-green-700';
                        $statusText = 'Lengkap 5/5';
                    }

                    if ($hari['status'] === 'belum_lengkap') {
                        $cardClass = 'bg-red-50 border-red-200 hover:bg-red-100';
                        $textClass = 'text-red-700';
                        $statusText = $hari['jumlahSholat'] . '/5 Sholat';
                    }

                    $modalId = 'modal-rekap-' . $hari['key'];
                @endphp

                <button type="button"
                        onclick="openModal('{{ $modalId }}')"
                        class="min-h-[92px] text-left rounded-2xl border p-4 transition {{ $cardClass }}">

                    <div class="font-bold text-lg {{ $textClass }}">
                        {{ $hari['tanggal']->format('d') }}
                    </div>

                    <div class="text-xs mt-4 {{ $textClass }}">
                        {{ $statusText }}
                    </div>

                </button>

                {{-- MODAL --}}
                <div id="{{ $modalId }}"
                     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">

                    <div class="bg-white rounded-[2rem] shadow-xl w-full max-w-md p-7 relative">

                        <button type="button"
                                onclick="closeModal('{{ $modalId }}')"
                                class="absolute right-5 top-5 text-gray-400 hover:text-gray-700 text-xl">
                            ×
                        </button>

                        <h3 class="text-2xl font-bold text-[#1F252D]">
                            Rekapan Sholat
                        </h3>

                        <p class="text-gray-500 mt-2">
                            {{ $hari['tanggal']->translatedFormat('l, d F Y') }}
                        </p>

                        <div class="mt-6 border border-gray-200 rounded-2xl p-5">

                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold text-[#1F252D]">
                                    Hasil Rekapan
                                </h4>

                                <span class="text-sm text-gray-400">
                                    {{ $hari['jumlahSholat'] }}/5 Sholat
                                </span>
                            </div>

                            @php
                                $rekap = $hari['rekap'] ?? [
                                    'subuh' => false,
                                    'dzuhur' => false,
                                    'ashar' => false,
                                    'maghrib' => false,
                                    'isya' => false,
                                ];
                            @endphp

                            <div class="space-y-3">

                                <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
                                    <span>Subuh</span>
                                    @if($rekap['subuh'])
                                        <span class="text-green-600 font-bold">Sudah</span>
                                    @else
                                        <span class="text-red-600 font-bold">Belum</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
                                    <span>Dzuhur</span>
                                    @if($rekap['dzuhur'])
                                        <span class="text-green-600 font-bold">Sudah</span>
                                    @else
                                        <span class="text-red-600 font-bold">Belum</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
                                    <span>Ashar</span>
                                    @if($rekap['ashar'])
                                        <span class="text-green-600 font-bold">Sudah</span>
                                    @else
                                        <span class="text-red-600 font-bold">Belum</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
                                    <span>Maghrib</span>
                                    @if($rekap['maghrib'])
                                        <span class="text-green-600 font-bold">Sudah</span>
                                    @else
                                        <span class="text-red-600 font-bold">Belum</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
                                    <span>Isya</span>
                                    @if($rekap['isya'])
                                        <span class="text-green-600 font-bold">Sudah</span>
                                    @else
                                        <span class="text-red-600 font-bold">Belum</span>
                                    @endif
                                </div>

                            </div>

                            @if($hari['status'] === 'lengkap')
                                <div class="mt-5 bg-green-100 text-green-700 text-center font-bold py-4 rounded-2xl">
                                    Sholat sudah lengkap.
                                </div>
                            @elseif($hari['status'] === 'belum_lengkap')
                                <div class="mt-5 bg-red-100 text-red-700 text-center font-bold py-4 rounded-2xl">
                                    Sholat belum lengkap.
                                </div>
                            @else
                                <div class="mt-5 bg-gray-100 text-gray-600 text-center font-bold py-4 rounded-2xl">
                                    Belum ada data sholat.
                                </div>
                            @endif

                            <a href="{{ route('orangtua.ibadah-sholat.index', ['tanggal' => $hari['key']]) }}"
                               class="mt-4 w-full inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-5 py-3 rounded-2xl font-bold transition">
                                Input di Tanggal Ini
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('[id^="modal-rekap-"]').forEach(function (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });
</script>

@endsection
