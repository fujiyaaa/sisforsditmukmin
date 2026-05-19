@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- FORM TAMBAH GURU -->
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-xl">

        <h1 class="text-3xl font-bold text-[#4D9A72] mb-6">
            Kelola Guru
        </h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/guru" method="POST" class="space-y-5">
            @csrf

            <!-- NAMA -->
            <input type="text"
                   name="name"
                   placeholder="Nama Guru"
                   class="w-full px-4 py-3 border rounded-xl">

            <!-- EMAIL -->
            <input type="email"
                   name="email"
                   placeholder="Email"
                   class="w-full px-4 py-3 border rounded-xl">

            <!-- PASSWORD -->
            <input type="password"
                   name="password"
                   placeholder="Password"
                   class="w-full px-4 py-3 border rounded-xl">

            <button type="submit"
                    class="bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                Simpan
            </button>

        </form>

    </div>

    <!-- TABEL GURU -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-[#4D9A72] mb-6">
            Data Guru
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>

                    <tr class="bg-[#4D9A72] text-white">

                        <th class="p-4 text-left rounded-l-xl">
                            Nama
                        </th>

                        <th class="p-4 text-left">
                            Email
                        </th>

                        <th class="p-4 text-left rounded-r-xl">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($guru as $g)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="p-4">
                                {{ $g->name }}
                            </td>

                            <td class="p-4">
                                {{ $g->email }}
                            </td>

                            <td class="p-4 flex gap-2">

                                <!-- EDIT -->
                                <button type="button"
                                        onclick="document.getElementById('edit-guru-{{ $g->id }}').classList.remove('hidden')"
                                        class="bg-yellow-500 text-white px-4 py-2 rounded-xl">
                                    Edit
                                </button>

                                <!-- DELETE -->
                                <form action="/admin/guru/{{ $g->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded-xl">
                                        Hapus
                                    </button>
                                </form>

                            </td>

                        </tr>

                        <!-- FORM EDIT -->
                        <tr id="edit-guru-{{ $g->id }}" class="hidden bg-gray-50">

                            <td colspan="3" class="p-6">

                                <form action="/admin/guru/{{ $g->id }}"
                                      method="POST"
                                      class="grid grid-cols-1 md:grid-cols-4 gap-4">

                                    @csrf
                                    @method('PUT')

                                    <input type="text"
                                           name="name"
                                           value="{{ $g->name }}"
                                           class="px-4 py-3 border rounded-xl">

                                    <input type="email"
                                           name="email"
                                           value="{{ $g->email }}"
                                           class="px-4 py-3 border rounded-xl">

                                    <input type="password"
                                           name="password"
                                           placeholder="Password baru (opsional)"
                                           class="px-4 py-3 border rounded-xl">

                                    <div class="flex gap-2">

                                        <button type="submit"
                                                class="bg-[#4D9A72] text-white px-4 py-2 rounded-xl">
                                            Update
                                        </button>

                                        <button type="button"
                                                onclick="document.getElementById('edit-guru-{{ $g->id }}').classList.add('hidden')"
                                                class="bg-gray-400 text-white px-4 py-2 rounded-xl">
                                            Batal
                                        </button>

                                    </div>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="3"
                                class="p-6 text-center text-gray-500">

                                Belum ada data guru

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
