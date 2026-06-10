@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100">
        <h1 class="text-3xl font-bold text-[#1F252D]">
            Hak Akses Guru
        </h1>

        <p class="text-gray-500 mt-2">
            Atur kelas mana saja yang dapat diakses oleh setiap guru.
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100">
        <h2 class="text-2xl font-bold text-[#1F252D] mb-6">
            Daftar Guru
        </h2>

        <div class="space-y-6">
            @forelse($gurus as $guru)
                <form action="{{ route('admin.hak-akses-guru.update', $guru->id) }}"
                      method="POST"
                      class="border border-gray-100 rounded-3xl p-6 bg-gray-50">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                        <div class="lg:w-1/3">
                            <h3 class="text-xl font-bold text-[#1F252D]">
                                {{ $guru->name }}
                            </h3>

                            <p class="text-gray-500 mt-1">
                                {{ $guru->nip }}
                            </p>

                            <div class="mt-4">
                                <p class="text-sm font-semibold text-gray-700">
                                    Kelas saat ini:
                                </p>

                                <div class="flex flex-wrap gap-2 mt-2">
                                    @forelse($guru->kelasDiampu as $kelasItem)
                                        <span class="bg-[#EEF7F1] text-[#2F6F4F] px-4 py-2 rounded-xl text-sm font-semibold">
                                            {{ $kelasItem->nama_kelas }}
                                        </span>
                                    @empty
                                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-xl text-sm font-semibold">
                                            Belum ada akses kelas
                                        </span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-2/3">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Pilih Kelas yang Bisa Diakses
                            </label>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                                @foreach($kelas as $kelasItem)
                                    <label class="flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-4 py-3 cursor-pointer hover:bg-[#EEF7F1] transition">
                                        <input type="checkbox"
                                               name="kelas_id[]"
                                               value="{{ $kelasItem->id }}"
                                               class="rounded text-[#4D9A72] focus:ring-[#4D9A72]"
                                               {{ $guru->kelasDiampu->contains('id', $kelasItem->id) ? 'checked' : '' }}>

                                        <span class="text-gray-700 font-medium">
                                            {{ $kelasItem->nama_kelas }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-5">
                                <button type="submit"
                                        class="bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition">
                                    Simpan Hak Akses
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            @empty
                <div class="text-center text-gray-500 py-10">
                    Belum ada akun guru.
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
