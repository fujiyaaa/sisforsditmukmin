@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F252D] via-[#2F6F4F] to-[#4D9A72] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-[#DDF3E7]/20 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-8">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 tracking-wide">
                    KELOLA AKUN
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Data Akun
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Kelola akun admin, guru, dan orang tua siswa.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[250px] border border-white/15">
                <p class="text-sm text-white/70">
                    Total Akun
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $users->count() }}
                </h2>

                <p class="text-white/70 text-sm mt-1">
                    akun terdaftar
                </p>
            </div>

        </div>

    </div>

    <!-- FORM TAMBAH AKUN -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Tambah Akun
            </h2>

            <p class="text-gray-500 mt-1">
                Tambahkan akun sesuai role pengguna.
            </p>
        </div>

        <form method="POST"
              action="{{ route('admin.akun.store') }}"
              class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Role
                    </label>

                    <select name="role"
                            id="role"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                            required>

                        <option value="">
                            Pilih Role
                        </option>

                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>
                            Guru
                        </option>

                        <option value="orangtua" {{ old('role') == 'orangtua' ? 'selected' : '' }}>
                            Orang Tua
                        </option>

                    </select>
                </div>

                <div id="email-wrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Admin
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@email.com"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <p class="text-xs text-gray-400 mt-2">
                        Email hanya dipakai untuk akun admin.
                    </p>
                </div>

                <div id="phone-wrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        No. Telepon
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <p class="text-xs text-gray-400 mt-2">
                        Dipakai untuk kontak guru dan orang tua.
                    </p>
                </div>

                <div id="nip-wrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        NIP Guru
                    </label>

                    <input type="text"
                           name="nip"
                           value="{{ old('nip') }}"
                           placeholder="Masukkan NIP guru"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <p class="text-xs text-gray-400 mt-2">
                        NIP digunakan untuk login guru.
                    </p>
                </div>

                <div id="siswa-wrapper">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Hubungkan ke Siswa
                    </label>

                    <select name="siswa_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                        <option value="">
                            Pilih siswa
                        </option>

                        @forelse($siswas as $siswa)
                            <option value="{{ $siswa->id }}"
                                {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}
                                {{ $siswa->orangtua_id ? 'disabled' : '' }}>

                                {{ $siswa->nis }} - {{ $siswa->nama }}
                                {{ $siswa->kelas ? '(' . $siswa->kelas->nama_kelas . ')' : '' }}
                                {{ $siswa->orangtua_id ? ' - sudah terhubung' : '' }}

                            </option>
                        @empty
                            <option value="" disabled>
                                Belum ada data siswa
                            </option>
                        @endforelse

                    </select>

                    <p class="text-xs text-gray-400 mt-2">
                        Satu siswa hanya bisa terhubung ke satu akun orang tua.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>

                    <input type="text"
                           name="password"
                           value="{{ old('password', 'password123') }}"
                           placeholder="Masukkan password"
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                           required>

                    <p class="text-xs text-gray-400 mt-2">
                        User wajib mengganti password setelah login.
                    </p>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-[#2F7D55] text-white px-8 py-4 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Simpan Akun
                </button>
            </div>

        </form>

    </div>

    <!-- DATA AKUN -->
    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Data Akun
                </h2>

                <p class="text-gray-500 mt-1">
                    Daftar akun admin, guru, dan orang tua.
                </p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 md:items-center">

                <input type="text"
                       id="searchAkun"
                       placeholder="Cari nama, kontak, NIP..."
                       class="px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72] min-w-[250px]">

                <select id="filterRole"
                        class="px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72] min-w-[180px]">

                    <option value="">
                        Semua Role
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                    <option value="guru">
                        Guru
                    </option>

                    <option value="orangtua">
                        Orang Tua
                    </option>

                </select>

                <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                    <span id="jumlahAkunTampil">{{ $users->count() }}</span> akun
                </div>

            </div>

        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

            <table class="w-full min-w-[1200px]">

                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">Role</th>
                        <th class="px-6 py-4 text-left font-semibold">Kontak</th>
                        <th class="px-6 py-4 text-left font-semibold">Login</th>
                        <th class="px-6 py-4 text-left font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($users as $index => $user)

                        @php
                            $roleLabel = match($user->role) {
                                'admin' => 'Admin',
                                'guru' => 'Guru',
                                'orangtua' => 'Orang Tua',
                                default => $user->role,
                            };

                            $roleBadge = match($user->role) {
                                'admin' => 'bg-blue-100 text-blue-700',
                                'guru' => 'bg-yellow-100 text-yellow-700',
                                'orangtua' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700',
                            };

                            $kontakTampil = $user->role === 'admin'
                                ? ($user->email ?? '-')
                                : ($user->phone ?? 'Lihat kontak');

                            if ($user->role === 'admin') {
                                $loginTampil = $user->email ?? '-';
                            } elseif ($user->role === 'guru') {
                                $loginTampil = $user->nip ?? '-';
                            } elseif ($user->role === 'orangtua') {
                                $loginTampil = $user->siswa->nis ?? '-';
                            } else {
                                $loginTampil = '-';
                            }
                        @endphp

                        <tr class="hover:bg-[#FAFCFB] transition akun-row"
                            data-role="{{ $user->role }}"
                            data-search="{{ strtolower($user->name . ' ' . $kontakTampil . ' ' . ($user->nip ?? '') . ' ' . ($user->siswa->nis ?? '') . ' ' . ($user->siswa->nama ?? '')) }}">

                            <td class="px-6 py-5 text-gray-700 no-akun-cell">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">

                                    <div class="w-11 h-11 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-[#1F252D]">
                                            {{ $user->name }}
                                        </h4>

                                        <p class="text-sm text-gray-400">
                                            Akun {{ $roleLabel }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="{{ $roleBadge }} px-4 py-2 rounded-2xl text-sm font-bold">
                                    {{ $roleLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-5">

                                @if($user->role === 'orangtua')

                                    <button type="button"
                                            class="btn-detail-kontak text-left group"
                                            data-role="orangtua"
                                            data-nama="{{ $user->name }}"
                                            data-phone="{{ $user->phone ?? '-' }}"
                                            data-nis="{{ $user->siswa->nis ?? '-' }}"
                                            data-siswa="{{ $user->siswa->nama ?? '-' }}">

                                        <p class="font-bold text-[#1F252D] group-hover:text-[#2F7D55] transition">
                                            {{ $user->phone ?? 'Lihat kontak' }}
                                        </p>

                                        <p class="text-sm text-[#2F7D55] font-semibold mt-1">
                                            Lihat detail orang tua
                                        </p>

                                    </button>

                                @elseif($user->role === 'guru')

                                    <button type="button"
                                            class="btn-detail-kontak text-left group"
                                            data-role="guru"
                                            data-nama="{{ $user->name }}"
                                            data-phone="{{ $user->phone ?? '-' }}"
                                            data-nip="{{ $user->nip ?? '-' }}">

                                        <p class="font-bold text-[#1F252D] group-hover:text-[#2F7D55] transition">
                                            {{ $user->phone ?? 'Lihat kontak' }}
                                        </p>

                                        <p class="text-sm text-[#2F7D55] font-semibold mt-1">
                                            Lihat detail guru
                                        </p>

                                    </button>

                                @else

                                    <button type="button"
                                            class="btn-detail-kontak text-left group"
                                            data-role="admin"
                                            data-nama="{{ $user->name }}"
                                            data-email="{{ $user->email ?? '-' }}">

                                        <p class="font-bold text-[#1F252D] group-hover:text-[#2F7D55] transition">
                                            {{ $user->email ?? '-' }}
                                        </p>

                                        <p class="text-sm text-[#2F7D55] font-semibold mt-1">
                                            Lihat detail admin
                                        </p>

                                    </button>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-gray-600">

                                @if($user->role === 'admin')
                                    <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        Email
                                    </span>

                                    <p class="text-sm mt-2">
                                        {{ $loginTampil }}
                                    </p>
                                @elseif($user->role === 'guru')
                                    <span class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        NIP
                                    </span>

                                    <p class="text-sm mt-2">
                                        {{ $loginTampil }}
                                    </p>
                                @else
                                    <span class="bg-green-50 text-green-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        NIS Siswa
                                    </span>

                                    <p class="text-sm mt-2">
                                        {{ $loginTampil }}
                                    </p>
                                @endif

                            </td>

                            <td class="px-6 py-5">
                                @if($user->must_change_password)
                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        Wajib ganti password
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-2xl text-sm font-bold">
                                        Aktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">

                                <div class="flex items-center justify-center gap-2">

                                    <button type="button"
                                            onclick="openEditModal('editModal{{ $user->id }}')"
                                            class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl hover:bg-blue-200 transition font-bold">
                                        Edit
                                    </button>

                                    <button type="button"
                                            onclick="openResetModal('resetModal{{ $user->id }}')"
                                            class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl hover:bg-yellow-200 transition font-bold">
                                        Reset
                                    </button>

                                    <form method="POST"
                                          action="{{ route('admin.akun.destroy', $user->id) }}"
                                          class="delete-akun-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-100 text-red-700 px-4 py-2 rounded-xl hover:bg-red-200 transition font-bold">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        <!-- MODAL EDIT AKUN -->
                        <div id="editModal{{ $user->id }}"
                             class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">

                            <div class="bg-white w-full max-w-2xl rounded-[2rem] shadow-xl p-8 max-h-[90vh] overflow-y-auto">

                                <div class="flex items-center justify-between mb-6">

                                    <div>
                                        <h2 class="text-2xl font-bold text-[#1F252D]">
                                            Edit Akun
                                        </h2>

                                        <p class="text-gray-500 mt-1">
                                            Ubah data akun {{ $user->name }}.
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="closeEditModal('editModal{{ $user->id }}')"
                                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold">
                                        ×
                                    </button>

                                </div>

                                <form method="POST"
                                      action="{{ route('admin.akun.update', $user->id) }}"
                                      class="space-y-5 edit-akun-form">

                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama
                                        </label>

                                        <input type="text"
                                               name="name"
                                               value="{{ old('name', $user->name) }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                               required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Role
                                        </label>

                                        <input type="text"
                                               value="{{ $roleLabel }}"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-100 text-gray-600"
                                               readonly>
                                    </div>

                                    @if($user->role === 'admin')

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Email
                                            </label>

                                            <input type="email"
                                                   name="email"
                                                   value="{{ old('email', $user->email) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                    @endif

                                    @if($user->role === 'guru')

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    No. Telepon
                                                </label>

                                                <input type="text"
                                                       name="phone"
                                                       value="{{ old('phone', $user->phone) }}"
                                                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                       required>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    NIP
                                                </label>

                                                <input type="text"
                                                       name="nip"
                                                       value="{{ old('nip', $user->nip) }}"
                                                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                       required>
                                            </div>

                                        </div>

                                    @endif

                                    @if($user->role === 'orangtua')

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                No. Telepon
                                            </label>

                                            <input type="text"
                                                   name="phone"
                                                   value="{{ old('phone', $user->phone) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Siswa Terhubung
                                            </label>

                                            <select name="siswa_id"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                                    required>

                                                @if(!$user->siswa)
                                                    <option value="" selected disabled>
                                                        Pilih siswa
                                                    </option>
                                                @endif

                                                @foreach($siswas as $siswa)
                                                    <option value="{{ $siswa->id }}"
                                                        {{ old('siswa_id', $user->siswa?->id) == $siswa->id ? 'selected' : '' }}
                                                        {{ $siswa->orangtua_id && $siswa->orangtua_id != $user->id ? 'disabled' : '' }}>

                                                        {{ $siswa->nis }} - {{ $siswa->nama }}
                                                        {{ $siswa->kelas ? '(' . $siswa->kelas->nama_kelas . ')' : '' }}
                                                        {{ $siswa->orangtua_id && $siswa->orangtua_id != $user->id ? ' - sudah terhubung' : '' }}

                                                    </option>
                                                @endforeach

                                            </select>

                                            <p class="text-xs text-gray-400 mt-2">
                                                Siswa yang sedang terhubung akan otomatis terpilih.
                                            </p>
                                        </div>

                                    @endif

                                    <div class="flex justify-end gap-3 pt-4">

                                        <button type="button"
                                                onclick="closeEditModal('editModal{{ $user->id }}')"
                                                class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold">
                                            Batal
                                        </button>

                                        <button type="submit"
                                                class="px-6 py-3 rounded-2xl bg-[#2F7D55] text-white hover:bg-[#256B47] transition font-bold">
                                            Simpan Perubahan
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                        <!-- MODAL RESET PASSWORD -->
                        <div id="resetModal{{ $user->id }}"
                             class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">

                            <div class="bg-white w-full max-w-md rounded-[2rem] shadow-xl p-8">

                                <div class="flex items-center justify-between mb-6">

                                    <div>
                                        <h2 class="text-2xl font-bold text-[#1F252D]">
                                            Reset Password
                                        </h2>

                                        <p class="text-gray-500 mt-1">
                                            Reset password untuk {{ $user->name }}.
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="closeResetModal('resetModal{{ $user->id }}')"
                                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold">
                                        ×
                                    </button>

                                </div>

                                <form method="POST"
                                      action="{{ route('admin.akun.reset-password', $user->id) }}"
                                      class="space-y-5 reset-password-form">

                                    @csrf

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Password Baru
                                        </label>

                                        <input type="text"
                                               name="password_baru"
                                               value="password123"
                                               class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                                               required>
                                    </div>

                                    <div class="flex justify-end gap-3 pt-4">

                                        <button type="button"
                                                onclick="closeResetModal('resetModal{{ $user->id }}')"
                                                class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold">
                                            Batal
                                        </button>

                                        <button type="submit"
                                                class="px-6 py-3 rounded-2xl bg-[#2F7D55] text-white hover:bg-[#256B47] transition font-bold">
                                            Simpan
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                Belum ada data akun.
                            </td>
                        </tr>

                    @endforelse

                    <tr id="emptyAkunRow" class="hidden">
                        <td colspan="7" class="text-center py-12 text-gray-500">
                            Tidak ada akun yang sesuai filter.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    const roleSelect = document.getElementById('role');
    const emailWrapper = document.getElementById('email-wrapper');
    const phoneWrapper = document.getElementById('phone-wrapper');
    const nipWrapper = document.getElementById('nip-wrapper');
    const siswaWrapper = document.getElementById('siswa-wrapper');

    function toggleRoleFields() {
        if (!roleSelect) return;

        const role = roleSelect.value;

        emailWrapper.style.display = 'none';
        phoneWrapper.style.display = 'none';
        nipWrapper.style.display = 'none';
        siswaWrapper.style.display = 'none';

        if (role === 'admin') {
            emailWrapper.style.display = 'block';
        }

        if (role === 'guru') {
            phoneWrapper.style.display = 'block';
            nipWrapper.style.display = 'block';
        }

        if (role === 'orangtua') {
            phoneWrapper.style.display = 'block';
            siswaWrapper.style.display = 'block';
        }
    }

    if (roleSelect) {
        roleSelect.addEventListener('change', toggleRoleFields);
        toggleRoleFields();
    }

    const searchAkun = document.getElementById('searchAkun');
    const filterRole = document.getElementById('filterRole');
    const akunRows = document.querySelectorAll('.akun-row');
    const jumlahAkunTampil = document.getElementById('jumlahAkunTampil');
    const emptyAkunRow = document.getElementById('emptyAkunRow');

    function filterAkun() {
        const keyword = searchAkun.value.toLowerCase();
        const roleDipilih = filterRole.value;
        let totalTampil = 0;

        akunRows.forEach(function(row) {
            const searchText = row.dataset.search || '';
            const roleRow = row.dataset.role || '';

            const cocokSearch = searchText.includes(keyword);
            const cocokRole = roleDipilih === '' || roleRow === roleDipilih;

            if (cocokSearch && cocokRole) {
                row.style.display = '';
                totalTampil++;

                const noCell = row.querySelector('.no-akun-cell');
                if (noCell) {
                    noCell.textContent = totalTampil;
                }

            } else {
                row.style.display = 'none';
            }
        });

        jumlahAkunTampil.textContent = totalTampil;

        if (emptyAkunRow) {
            if (totalTampil === 0 && akunRows.length > 0) {
                emptyAkunRow.classList.remove('hidden');
            } else {
                emptyAkunRow.classList.add('hidden');
            }
        }
    }

    if (searchAkun) {
        searchAkun.addEventListener('keyup', filterAkun);
    }

    if (filterRole) {
        filterRole.addEventListener('change', filterAkun);
    }

    filterAkun();

    function openEditModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openResetModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeResetModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelectorAll('.btn-detail-kontak').forEach(function(button) {
        button.addEventListener('click', function() {
            const role = this.dataset.role;

            if (role === 'orangtua') {
                Swal.fire({
                    title: 'Kontak Orang Tua',
                    html: `
                        <div style="text-align:left; line-height:1.8">
                            <p><b>Nama Orang Tua:</b><br>${this.dataset.nama}</p>
                            <p><b>No. Telepon:</b><br>${this.dataset.phone}</p>
                            <p><b>NIS Siswa:</b><br>${this.dataset.nis}</p>
                            <p><b>Nama Siswa:</b><br>${this.dataset.siswa}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#2F7D55',
                    confirmButtonText: 'Tutup'
                });
            }

            if (role === 'guru') {
                Swal.fire({
                    title: 'Kontak Guru',
                    html: `
                        <div style="text-align:left; line-height:1.8">
                            <p><b>Nama Guru:</b><br>${this.dataset.nama}</p>
                            <p><b>NIP:</b><br>${this.dataset.nip}</p>
                            <p><b>No. Telepon:</b><br>${this.dataset.phone}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#2F7D55',
                    confirmButtonText: 'Tutup'
                });
            }

            if (role === 'admin') {
                Swal.fire({
                    title: 'Kontak Admin',
                    html: `
                        <div style="text-align:left; line-height:1.8">
                            <p><b>Nama Admin:</b><br>${this.dataset.nama}</p>
                            <p><b>Email:</b><br>${this.dataset.email}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#2F7D55',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    });

    document.querySelectorAll('.delete-akun-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Akun?',
                text: 'Akun yang dihapus tidak bisa digunakan lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.reset-password-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Reset Password?',
                text: 'User akan wajib mengganti password setelah login.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2F7D55',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2F7D55',
            confirmButtonText: 'Oke'
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#2F7D55',
            confirmButtonText: 'Oke'
        });
    </script>
@endif

@endsection
