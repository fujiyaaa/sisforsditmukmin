@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- FORM TAMBAH SISWA -->
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-xl">

        <h1 class="text-3xl font-bold text-[#2F6F4F] mb-6">
            Tambah Siswa
        </h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/siswa" method="POST" class="space-y-5">
            @csrf

            <input type="text"
                   name="nis"
                   placeholder="NIS"
                   value="{{ old('nis') }}"
                   class="w-full px-4 py-3 border rounded-xl">

            <input type="text"
                   name="nama"
                   placeholder="Nama"
                   value="{{ old('nama') }}"
                   class="w-full px-4 py-3 border rounded-xl">

            <select name="kelas_id" class="w-full px-4 py-3 border rounded-xl">
                <option value="">Pilih Kelas</option>

                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                Simpan
            </button>
        </form>

    </div>

    <!-- TABEL SISWA -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-[#2F6F4F] mb-6">
            Data Siswa
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>
                    <tr class="bg-[#4D9A72] text-white">
                        <th class="p-4 text-left rounded-l-xl">NIS</th>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Kelas</th>
                        <th class="p-4 text-left rounded-r-xl">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $siswa)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="p-4">
                                {{ $siswa->nis }}
                            </td>

                            <td class="p-4">
                                {{ $siswa->nama }}
                            </td>

                            <td class="p-4">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="p-4 flex gap-2">

                                <button type="button"
                                        onclick="document.getElementById('edit-{{ $siswa->id }}').classList.remove('hidden')"
                                        class="bg-yellow-500 text-white px-4 py-2 rounded-xl">
                                    Edit
                                </button>

                                <form action="/admin/siswa/{{ $siswa->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
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
                        <tr id="edit-{{ $siswa->id }}" class="hidden bg-gray-50">
                            <td colspan="4" class="p-6">

                                <form action="/admin/siswa/{{ $siswa->id }}"
                                      method="POST"
                                      class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    @csrf
                                    @method('PUT')

                                    <input type="text"
                                           name="nis"
                                           value="{{ $siswa->nis }}"
                                           class="px-4 py-3 border rounded-xl">

                                    <input type="text"
                                           name="nama"
                                           value="{{ $siswa->nama }}"
                                           class="px-4 py-3 border rounded-xl">

                                    <select name="kelas_id"
                                            class="px-4 py-3 border rounded-xl">
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}"
                                                {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="flex gap-2">
                                        <button type="submit"
                                                class="bg-[#4D9A72] text-white px-4 py-2 rounded-xl">
                                            Update
                                        </button>

                                        <button type="button"
                                                onclick="document.getElementById('edit-{{ $siswa->id }}').classList.add('hidden')"
                                                class="bg-gray-400 text-white px-4 py-2 rounded-xl">
                                            Batal
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                Belum ada data siswa
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
