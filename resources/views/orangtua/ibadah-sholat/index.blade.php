@extends('layoutsOrtu.app')

@section('content')

<div class="bg-white rounded-3xl shadow-md p-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">

        <div>
                <h1 class="text-4xl font-bold text-[#1F252D]">
                    Monitoring Sholat Fardhu
                </h1>

        </div>
        <a href="{{ route('orangtua.ibadah-sholat.riwayat') }}"
   class="bg-[#2F6F4F] text-white px-6 py-3 rounded-xl hover:bg-[#24583e] transition shadow-sm">
    Lihat Riwayat
</a>

    </div>

    <!-- DATA SISWA -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

        <div class="bg-[#EEF7F1] rounded-2xl p-5">
            <p class="text-sm text-gray-500">NIS</p>
            <h3 class="text-xl font-bold text-[#2F7D55]">
                {{ $siswa->nis }}
            </h3>
        </div>

        <div class="bg-[#EEF7F1] rounded-2xl p-5">
            <p class="text-sm text-gray-500">Nama Anak</p>
            <h3 class="text-xl font-bold text-[#2F7D55]">
                {{ $siswa->nama }}
            </h3>
        </div>

        <div class="bg-[#EEF7F1] rounded-2xl p-5">
            <p class="text-sm text-gray-500">Kelas</p>
            <h3 class="text-xl font-bold text-[#2F7D55]">
                {{ $siswa->kelas->nama_kelas ?? '-' }}
            </h3>
        </div>

    </div>

    <!-- FORM INPUT -->
    <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">

        <h2 class="text-2xl font-bold text-[#1F252D] mb-5">
            Input Monitoring Sholat
        </h2>

        <form action="{{ route('orangtua.ibadah-sholat.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ old('tanggal', date('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-3 font-semibold text-gray-700">
                    Checklist Sholat Fardhu
                </label>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                    <label class="flex items-center gap-3 bg-white border rounded-xl px-4 py-3 cursor-pointer">
                        <input type="checkbox" name="subuh" class="w-5 h-5">
                        <span>Subuh</span>
                    </label>

                    <label class="flex items-center gap-3 bg-white border rounded-xl px-4 py-3 cursor-pointer">
                        <input type="checkbox" name="dzuhur" class="w-5 h-5">
                        <span>Dzuhur</span>
                    </label>

                    <label class="flex items-center gap-3 bg-white border rounded-xl px-4 py-3 cursor-pointer">
                        <input type="checkbox" name="ashar" class="w-5 h-5">
                        <span>Ashar</span>
                    </label>

                    <label class="flex items-center gap-3 bg-white border rounded-xl px-4 py-3 cursor-pointer">
                        <input type="checkbox" name="maghrib" class="w-5 h-5">
                        <span>Maghrib</span>
                    </label>

                    <label class="flex items-center gap-3 bg-white border rounded-xl px-4 py-3 cursor-pointer">
                        <input type="checkbox" name="isya" class="w-5 h-5">
                        <span>Isya</span>
                    </label>

                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          rows="3"
                          class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                          placeholder="Contoh: Subuh berjamaah, dzuhur di sekolah">{{ old('keterangan') }}</textarea>
            </div>

            <button type="submit"
                    class="bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#3F825F] transition shadow-sm">
                Simpan Monitoring
            </button>

        </form>

    </div>

    <h1 class="text-4xl font-semibold text-[#1F252D]">
                    Terkini
                </h1>

            <!-- RIWAYAT MONITORING -->

<div class="space-y-8">

    @forelse($monitoringSholats as $tanggalData => $items)

        <div class="bg-white rounded-3xl shadow-lg p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

                <div>
                    <h2 class="text-2xl font-bold text-[#2F6F4F]">
                        Tanggal {{ \Carbon\Carbon::parse($tanggalData)->format('d-m-Y') }}
                    </h2>

                    <p class="text-gray-500">
                        Total data: {{ $items->count() }} data monitoring
                    </p>
                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>
                        <tr class="bg-[#4D9A72] text-white">
                            <th class="p-4 text-left rounded-l-2xl whitespace-nowrap">Tanggal</th>
                            <th class="p-4 text-center whitespace-nowrap">Subuh</th>
                            <th class="p-4 text-center whitespace-nowrap">Dzuhur</th>
                            <th class="p-4 text-center whitespace-nowrap">Ashar</th>
                            <th class="p-4 text-center whitespace-nowrap">Maghrib</th>
                            <th class="p-4 text-center whitespace-nowrap">Isya</th>
                            <th class="p-4 text-center whitespace-nowrap">Sumber</th>
                            <th class="p-4 text-left rounded-r-2xl whitespace-nowrap">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($items as $item)

                            <tr class="border-b hover:bg-gray-50 transition">

                                <!-- TANGGAL -->
                                <td class="p-4 font-semibold text-gray-800 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>

                                <!-- SUBUH -->
                                <td class="p-4 text-center">
                                    @if($item->subuh)
                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                    @else
                                        <span class="text-red-500 font-bold text-lg">×</span>
                                    @endif
                                </td>

                                <!-- DZUHUR -->
                                <td class="p-4 text-center">
                                    @if($item->dzuhur)
                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                    @else
                                        <span class="text-red-500 font-bold text-lg">×</span>
                                    @endif
                                </td>

                                <!-- ASHAR -->
                                <td class="p-4 text-center">
                                    @if($item->ashar)
                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                    @else
                                        <span class="text-red-500 font-bold text-lg">×</span>
                                    @endif
                                </td>

                                <!-- MAGHRIB -->
                                <td class="p-4 text-center">
                                    @if($item->maghrib)
                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                    @else
                                        <span class="text-red-500 font-bold text-lg">×</span>
                                    @endif
                                </td>

                                <!-- ISYA -->
                                <td class="p-4 text-center">
                                    @if($item->isya)
                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                    @else
                                        <span class="text-red-500 font-bold text-lg">×</span>
                                    @endif
                                </td>

                                <!-- SUMBER -->
                                <td class="p-4 text-center whitespace-nowrap">
                                    @if($item->sumber === 'guru')
                                        <span class="inline-flex items-center justify-center bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                                            Guru
                                        </span>
                                    @elseif($item->sumber === 'orangtua')
                                        <span class="inline-flex items-center justify-center bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                                            Orang Tua
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-semibold">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <!-- KETERANGAN -->
                                <td class="p-4 text-gray-600 min-w-[220px]">
                                    {{ $item->keterangan ?: '-' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-3xl shadow-lg p-10 text-center">

            <div class="text-5xl mb-4">
                🕌
            </div>

            <h2 class="text-2xl font-bold text-gray-700">
                Belum ada data monitoring
            </h2>

            <p class="text-gray-500 mt-2">
                Belum ada data monitoring sholat untuk anak ini.
            </p>

        </div>

    @endforelse

</div>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@endsection
