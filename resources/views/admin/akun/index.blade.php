@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100">
        <h1 class="text-3xl font-bold text-[#1F252D]">
            Kelola Akun
        </h1>

        <p class="text-gray-500 mt-2">
            Admin dapat membuat akun admin, guru, dan orang tua.
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
            Tambah Akun
        </h2>

        <form action="{{ route('admin.akun.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded-2xl shadow-sm focus:ring-[#4D9A72] focus:border-[#4D9A72]"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full border-gray-300 rounded-2xl shadow-sm focus:ring-[#4D9A72] focus:border-[#4D9A72]"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Role
                </label>
                <select name="role"
                        id="role"
                        class="w-full border-gray-300 rounded-2xl shadow-sm focus:ring-[#4D9A72] focus:border-[#4D9A72]"
                        required>
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="orangtua" {{ old('role') == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Default
                </label>
                <input type="text"
                       name="password"
                       value="{{ old('password', 'password123') }}"
                       class="w-full border-gray-300 rounded-2xl shadow-sm focus:ring-[#4D9A72] focus:border-[#4D9A72]"
                       required>
            </div>

            <div class="md:col-span-2" id="siswa-wrapper">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Hubungkan ke Siswa
                </label>

                <select name="siswa_id"
                        class="w-full border-gray-300 rounded-2xl shadow-sm focus:ring-[#4D9A72] focus:border-[#4D9A72]">
                    <option value="">Pilih Siswa</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }}
                        </option>
                    @endforeach
                </select>

                <p class="text-sm text-gray-500 mt-2">
                    Wajib dipilih jika role akun adalah orang tua.
                </p>
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                        class="bg-[#4D9A72] text-white px-6 py-3 rounded-2xl hover:bg-[#2F6F4F] transition">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100">
        <h2 class="text-2xl font-bold text-[#1F252D] mb-6">
            Daftar Akun
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#EEF7F1] text-left">
                        <th class="p-4 rounded-l-2xl">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Siswa</th>
                        <th class="p-4">Status Password</th>
                        <th class="p-4 rounded-r-2xl">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b">
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $user->name }}
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <td class="p-4">
                                <span class="px-4 py-2 rounded-xl text-sm font-semibold bg-[#EEF7F1] text-[#2F6F4F]">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td class="p-4 text-gray-600">
                                {{ $user->siswa->nama ?? '-' }}
                            </td>

                            <td class="p-4">
                                @if($user->must_change_password)
                                    <span class="px-4 py-2 rounded-xl text-sm font-semibold bg-yellow-100 text-yellow-700">
                                        Belum diganti
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-xl text-sm font-semibold bg-green-100 text-green-700">
                                        Sudah diganti
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">
                                <form action="{{ route('admin.akun.destroy', $user->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-100 text-red-700 px-4 py-2 rounded-xl hover:bg-red-200 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                Belum ada akun.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    const roleSelect = document.getElementById('role');
    const siswaWrapper = document.getElementById('siswa-wrapper');

    function toggleSiswa() {
        if (roleSelect.value === 'orangtua') {
            siswaWrapper.style.display = 'block';
        } else {
            siswaWrapper.style.display = 'none';
        }
    }

    roleSelect.addEventListener('change', toggleSiswa);
    toggleSiswa();
</script>

@endsection
