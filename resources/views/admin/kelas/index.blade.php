@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-xl">

        <h1 class="text-3xl font-bold text-[#2F6F4F] mb-6">
            Kelola Kelas
        </h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/kelas" method="POST" class="space-y-5">
            @csrf

            <input type="text"
                   name="nama_kelas"
                   placeholder="Nama Kelas"
                   value="{{ old('nama_kelas') }}"
                   class="w-full px-4 py-3 border rounded-xl">

            <button type="submit"
                    class="bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                Simpan
            </button>
        </form>

    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-[#2F6F4F] mb-6">
            Data Kelas
        </h2>

        <table class="w-full border-collapse">

            <thead>
                <tr class="bg-[#4D9A72] text-white">
                    <th class="p-4 text-left rounded-l-xl">Nama Kelas</th>
                    <th class="p-4 text-left rounded-r-xl">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($kelas as $k)

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="p-4">
                            {{ $k->nama_kelas }}
                        </td>

                        <td class="p-4 flex gap-2">

                            <button type="button"
                                    onclick="document.getElementById('edit-kelas-{{ $k->id }}').classList.remove('hidden')"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-xl">
                                Edit
                            </button>

                            <form action="/admin/kelas/{{ $k->id }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-xl">
                                    Hapus
                                </button>
                            </form>

                        </td>

                    </tr>

                    <tr id="edit-kelas-{{ $k->id }}" class="hidden bg-gray-50">

                        <td colspan="2" class="p-6">

                            <form action="/admin/kelas/{{ $k->id }}"
                                  method="POST"
                                  class="flex gap-4">
                                @csrf
                                @method('PUT')

                                <input type="text"
                                       name="nama_kelas"
                                       value="{{ $k->nama_kelas }}"
                                       class="w-full px-4 py-3 border rounded-xl">

                                <button type="submit"
                                        class="bg-[#4D9A72] text-white px-4 py-2 rounded-xl">
                                    Update
                                </button>

                                <button type="button"
                                        onclick="document.getElementById('edit-kelas-{{ $k->id }}').classList.add('hidden')"
                                        class="bg-gray-400 text-white px-4 py-2 rounded-xl">
                                    Batal
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="2" class="p-6 text-center text-gray-500">
                            Belum ada data kelas
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
