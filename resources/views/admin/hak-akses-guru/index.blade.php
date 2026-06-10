@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    {{-- HERO HEADER --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/5 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-white/5 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>
                <p class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    MANAJEMEN AKSES
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-white">
                    Hak Akses Guru
                </h1>

                <p class="text-white/90 mt-3 max-w-2xl">
                    Atur kelas mana saja yang dapat diakses oleh setiap guru pada sistem SiMukmin.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur-sm border border-white/10 rounded-[1.5rem] px-6 py-4 text-white">
                <p class="text-xs text-white/70">
                    Total Guru
                </p>

                <h2 class="text-3xl font-bold mt-1">
                    {{ $gurus->count() ?? 0 }}
                </h2>
            </div>

        </div>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-[#EEF7F1] border border-[#DDF3E7] text-[#2F7D55] px-6 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl">

            <p class="font-bold mb-2">
                Data belum sesuai:
            </p>

            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- DAFTAR GURU --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-8 py-7 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Guru
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Pilih kelas yang dapat diakses oleh masing-masing guru.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-semibold">
                {{ $kelas->count() ?? 0 }} Kelas
            </div>

        </div>

        <div class="p-8 space-y-6">

            @forelse($gurus as $guru)

                <form action="{{ route('admin.hak-akses-guru.update', $guru->id) }}"
                      method="POST"
                      class="rounded-[2rem] border border-gray-100 bg-[#FAFCFB] p-6 hover:bg-white hover:shadow-sm transition">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                        {{-- INFO GURU --}}
                        <div class="xl:col-span-1">

                            <div class="flex items-start gap-4">

                                <div class="w-14 h-14 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold text-lg shrink-0">
                                    {{ strtoupper(substr($guru->name ?? 'G', 0, 1)) }}
                                </div>

                                <div class="min-w-0">
                                    <h3 class="text-xl font-bold text-[#1F252D] truncate">
                                        {{ $guru->name }}
                                    </h3>

                                    <p class="text-gray-500 mt-1">
                                        {{ $guru->nip ?? '-' }}
                                    </p>
                                </div>

                            </div>

                            <div class="mt-6 rounded-[1.5rem] bg-white border border-gray-100 p-5">

                                <div class="flex items-center justify-between gap-4 mb-4">

                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            Kelas Saat Ini
                                        </p>

                                        <p class="text-xs text-gray-400 mt-1">
                                            Akses kelas yang sedang aktif.
                                        </p>
                                    </div>

                                    <div class="inline-flex items-center justify-center bg-[#EEF7F1] text-[#2F7D55] px-3 py-2 rounded-xl text-sm font-bold">
                                        {{ $guru->kelasDiampu->count() }}
                                    </div>

                                </div>

                                <div class="flex flex-wrap gap-2">

                                    @forelse($guru->kelasDiampu as $kelasItem)

                                        <span class="inline-flex items-center bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-2xl text-sm font-semibold">
                                            {{ $kelasItem->nama_kelas }}
                                        </span>

                                    @empty

                                        <span class="inline-flex items-center bg-red-50 text-red-700 border border-red-100 px-4 py-2 rounded-2xl text-sm font-semibold">
                                            Belum ada akses kelas
                                        </span>

                                    @endforelse

                                </div>

                            </div>

                        </div>

                        {{-- PILIH KELAS --}}
                        <div class="xl:col-span-2">

                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                                <div>
                                    <label class="block text-sm font-bold text-[#1F252D]">
                                        Pilih Kelas yang Bisa Diakses
                                    </label>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Centang kelas yang boleh diakses oleh guru ini.
                                    </p>
                                </div>

                                <button type="submit"
                                        class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3 rounded-2xl font-semibold transition shadow-sm">
                                    Simpan Hak Akses
                                </button>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">

                                @foreach($kelas as $kelasItem)

                                    <label class="group flex items-center justify-between gap-4 bg-white border border-gray-200 rounded-2xl px-4 py-4 cursor-pointer hover:border-[#DDF3E7] hover:bg-[#F6FAF8] transition">

                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($kelasItem->nama_kelas ?? 'K', 0, 1)) }}
                                            </div>

                                            <span class="text-gray-700 font-semibold">
                                                {{ $kelasItem->nama_kelas }}
                                            </span>

                                        </div>

                                        <input type="checkbox"
                                               name="kelas_id[]"
                                               value="{{ $kelasItem->id }}"
                                               class="w-5 h-5 rounded accent-[#2F7D55] focus:ring-[#4D9A72]"
                                               {{ $guru->kelasDiampu->contains('id', $kelasItem->id) ? 'checked' : '' }}>

                                    </label>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </form>

            @empty

                <div class="rounded-[1.75rem] border border-dashed border-gray-200 bg-gray-50 p-12 text-center">

                    <div class="w-16 h-16 mx-auto rounded-3xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                        0
                    </div>

                    <h3 class="text-xl font-bold text-gray-700">
                        Belum ada akun guru
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Data guru akan muncul setelah akun guru dibuat.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection