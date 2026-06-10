@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <div class="relative overflow-hidden bg-[#2F7D55] rounded-[2rem] shadow-sm p-8">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-white/10 rounded-full"></div>

        <div class="relative z-10">
            <p class="inline-flex bg-white/15 text-white text-xs tracking-[0.25em] font-bold px-4 py-2 rounded-full mb-5">
                KALENDER SEKOLAH
            </p>

            <h1 class="text-3xl md:text-4xl font-bold text-white">
                Kelola Hari Libur
            </h1>

            <p class="text-white/90 mt-3 max-w-2xl">
                Atur tanggal merah atau hari libur sekolah agar input monitoring sholat orang tua menyesuaikan otomatis.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-5 py-4 rounded-2xl font-semibold border border-green-100">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 text-red-700 px-5 py-4 rounded-2xl font-semibold border border-red-100">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

            <h2 class="text-2xl font-bold text-[#1F252D]">
                Tambah Hari Libur
            </h2>

            <p class="text-gray-500 mt-1 mb-6">
                Masukkan tanggal libur sekolah atau tanggal merah.
            </p>

            <form action="{{ route('admin.hari-libur.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Tanggal Libur
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal') }}"
                           class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Nama Libur
                    </label>

                    <input type="text"
                           name="nama_libur"
                           value="{{ old('nama_libur') }}"
                           placeholder="Contoh: Libur Nasional"
                           class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="4"
                              placeholder="Opsional"
                              class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('keterangan') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3.5 rounded-2xl font-bold transition">
                    Simpan Hari Libur
                </button>
            </form>

        </div>

        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

            <h2 class="text-2xl font-bold text-[#1F252D]">
                Daftar Hari Libur
            </h2>

            <p class="text-gray-500 mt-1 mb-6">
                Tanggal yang terdaftar akan dianggap sebagai hari libur.
            </p>

            @if($hariLiburs->count() > 0)

                <div class="overflow-x-auto rounded-[1.5rem] border border-gray-100">

                    <table class="w-full border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-[#4D9A72] text-white">
                                <th class="p-4 text-left">Tanggal</th>
                                <th class="p-4 text-left">Nama Libur</th>
                                <th class="p-4 text-left">Keterangan</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($hariLiburs as $item)
                                <tr class="border-b border-gray-100 hover:bg-[#FAFCFB] transition">
                                    <td class="p-4 font-semibold text-[#1F252D]">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                    </td>

                                    <td class="p-4">
                                        {{ $item->nama_libur }}
                                    </td>

                                    <td class="p-4 text-gray-600">
                                        {{ $item->keterangan ?: '-' }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <form action="{{ route('admin.hari-libur.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus hari libur ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            @else

                <div class="rounded-[1.5rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">
                    <h3 class="text-xl font-bold text-gray-700">
                        Belum ada data hari libur
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Silakan tambahkan tanggal libur terlebih dahulu.
                    </p>
                </div>

            @endif

        </div>

    </div>

</div>

@endsection
