@extends('layoutsGuru.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F6B4A] via-[#2F7D55] to-[#4D9A72] p-8 shadow-sm">

        <div class="absolute -right-20 -top-20 w-72 h-72 rounded-full bg-white/10"></div>
        <div class="absolute -left-16 -bottom-20 w-52 h-52 rounded-full bg-white/10"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <p class="inline-flex items-center bg-white/15 text-white text-xs tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-5">
                    SETORAN QURAN
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    Monitoring Setoran Quran
                </h1>

                <p class="text-white/90 mt-3 max-w-2xl">
                    Pilih siswa untuk menginput setoran Tahfidz, Murajaah, atau Tilawah.
                </p>
            </div>

            <a href="{{ route('setoran.riwayat') }}"
               class="inline-flex items-center justify-center bg-white text-[#2F7D55] hover:bg-[#F0F8F4] px-6 py-3 rounded-2xl font-bold transition shadow-sm">
                Riwayat Setoran
            </a>

        </div>

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

    {{-- FILTER --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Filter Kelas
                </h2>

                <p class="text-gray-500 mt-1">
                    Tampilkan siswa berdasarkan kelas yang diampu.
                </p>
            </div>

            <form method="GET"
                  action="{{ route('setoran.index') }}"
                  class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full lg:max-w-3xl">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Pilih Kelas
                    </label>

                    <select name="kelas_id"
                            class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
                        <option value="">Semua Kelas</option>

                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" {{ (string) $kelas_id === (string) $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-4 rounded-2xl font-semibold transition shadow-sm">
                        Filter
                    </button>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('setoran.index') }}"
                       class="w-full text-center bg-[#EEF7F1] hover:bg-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold transition">
                        Reset
                    </a>
                </div>

            </form>

        </div>

    </div>

    {{-- DAFTAR SISWA --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Siswa
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Klik tombol input untuk menambahkan setoran Quran siswa.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $siswas->count() ?? 0 }} Siswa
            </div>

        </div>

        @if(isset($siswasByKelas) && $siswasByKelas->count() > 0)

            @foreach ($siswasByKelas as $namaKelas => $daftarSiswa)

                <div class="px-8 py-5 bg-[#F6FAF8] border-b border-gray-100">

                    <h3 class="text-lg font-bold text-[#2F7D55]">
                        {{ $namaKelas }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $daftarSiswa->count() }} siswa
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[850px]">

                        <thead>
                            <tr class="bg-[#4D9A72] text-white">
                                <th class="px-6 py-4 text-left font-semibold">No</th>
                                <th class="px-6 py-4 text-left font-semibold">NIS</th>
                                <th class="px-6 py-4 text-left font-semibold">Nama Siswa</th>
                                <th class="px-6 py-4 text-left font-semibold">Kelas</th>
                                <th class="px-6 py-4 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($daftarSiswa as $siswa)

                                <tr class="hover:bg-[#FAFCFB] transition">

                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-5 font-semibold text-gray-700">
                                        {{ $siswa->nis ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5">

                                        <div class="flex items-center gap-4">

                                            <div class="w-12 h-12 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($siswa->nama ?? '-', 0, 1)) }}
                                            </div>

                                            <div>
                                                <h4 class="font-bold text-[#1F252D]">
                                                    {{ $siswa->nama ?? '-' }}
                                                </h4>

                                                <p class="text-sm text-gray-400">
                                                    Siswa
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5">

                                        <a href="{{ route('setoran.create', $siswa->nis) }}"
                                           class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-5 py-3 rounded-2xl font-semibold transition shadow-sm">
                                            Input Setoran
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endforeach

        @else

            <div class="py-14 text-center">

                <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                    0
                </div>

                <h3 class="text-xl font-bold text-gray-700">
                    Belum ada siswa
                </h3>

                <p class="text-gray-500 mt-2">
                    Data siswa akan muncul sesuai kelas yang diampu.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
