@extends('layoutsAdmin.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F5F43] via-[#2F7D55] to-[#75C295] p-8 shadow-lg text-white">

        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full translate-x-24 -translate-y-24"></div>
        <div class="absolute left-0 bottom-0 w-60 h-60 bg-[#DDF3E7]/20 rounded-full -translate-x-24 translate-y-24"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-8">

            <div>
                <div class="inline-flex items-center bg-white/15 text-white px-4 py-2 rounded-full text-xs font-bold tracking-[0.2em] mb-5">
                    KELOLA AKUN
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Kelola Akun Pengguna
                </h1>

                <p class="text-white/80 mt-3 max-w-2xl">
                    Admin dapat membuat akun admin, guru, dan orang tua, serta mereset password jika user lupa password.
                </p>
            </div>

            <div class="bg-white/15 backdrop-blur px-6 py-5 rounded-3xl min-w-[250px] border border-white/15">
                <p class="text-sm text-white/70">
                    Total Akun
                </p>

                <h2 class="text-2xl font-bold mt-1" id="totalAkunDisplay">
                    {{ $users->count() }}
                </h2>

                <p class="text-white/70 text-sm mt-1">
                    akun ditampilkan
                </p>
            </div>

        </div>

    </div>

    <!-- TAMBAH AKUN -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">

        <div class="mb-7">
            <h2 class="text-2xl font-bold text-[#1F252D]">
                Tambah Akun
            </h2>

            <p class="text-gray-500 mt-1">
                Buat akun baru dengan password default. Guru login menggunakan NIP, orang tua login menggunakan NIS anak.
            </p>
        </div>

        <form action="{{ route('admin.akun.store') }}"
              method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @csrf

            <!-- NAMA -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama user"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                       required>
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="contoh@email.com"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                       required>

                <p class="text-sm text-gray-400 mt-2">
                    Admin tetap login menggunakan email.
                </p>
            </div>

            <!-- NIP GURU -->
            <div id="nip-wrapper">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    NIP Guru
                </label>

                <input type="text"
                       name="nip"
                       value="{{ old('nip') }}"
                       placeholder="Masukkan NIP guru"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                <p class="text-sm text-gray-400 mt-2">
                    Wajib diisi jika role akun adalah guru.
                </p>
            </div>

            <!-- ROLE -->
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

            <!-- PASSWORD DEFAULT -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Default
                </label>

                <input type="text"
                       name="password"
                       value="{{ old('password', 'password123') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]"
                       required>

                <p class="text-sm text-gray-400 mt-2">
                    User wajib mengganti password setelah login.
                </p>
            </div>

            <!-- HUBUNGKAN SISWA -->
            <div class="md:col-span-2" id="siswa-wrapper">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Hubungkan ke Siswa
                </label>

                <select name="siswa_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                    <option value="">
                        Pilih Siswa
                    </option>

                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nis }} - {{ $siswa->nama }} - {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach

                </select>

                <p class="text-sm text-gray-500 mt-2">
                    Wajib dipilih jika role akun adalah orang tua. Orang tua nanti login menggunakan NIS siswa.
                </p>
            </div>

            <!-- BUTTON -->
            <div class="md:col-span-2 flex justify-end">
                <button type="submit"
                        class="bg-[#2F7D55] text-white px-7 py-3 rounded-2xl hover:bg-[#256B47] transition font-bold">
                    Simpan Akun
                </button>
            </div>

        </form>

    </div>

    <!-- DAFTAR AKUN -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

            <div>
                <h2 class="text-2xl font-bold text-[#1F252D]">
                    Daftar Akun
                </h2>

                <p class="text-gray-500 mt-1">
                    Ketik nama/email atau pilih role untuk mencari akun secara langsung.
                </p>
            </div>

            <div class="bg-[#EEF7F1] text-[#2F7D55] px-5 py-3 rounded-2xl font-bold">
                <span id="jumlahAkun">{{ $users->count() }}</span> akun
            </div>

        </div>

        <!-- LIVE SEARCH & FILTER -->
        <div class="bg-[#F8FBF9] rounded-[2rem] p-6 border border-gray-100 mb-7">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <!-- SEARCH -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Cari Akun
                    </label>

                    <input type="text"
                           id="searchInput"
                           placeholder="Ketik nama, email, atau NIP..."
                           class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
                </div>

                <!-- ROLE FILTER -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Filter Role
                    </label>

                    <select id="roleFilter"
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

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
                </div>

                <!-- RESET -->
                <div class="flex items-end">
                    <button type="button"
                            id="resetFilter"
                            class="w-full text-center bg-white text-[#2F7D55] border border-[#DDF3E7] px-6 py-3 rounded-2xl hover:bg-[#EEF7F1] transition font-bold">
                        Reset
                    </button>
                </div>

            </div>

            <div id="filterInfo" class="hidden mt-5 flex flex-wrap gap-3">

                <div id="searchBadge" class="hidden bg-white text-gray-600 px-4 py-2 rounded-2xl border border-gray-100 text-sm">
                    Search:
                    <span id="searchBadgeText" class="font-bold text-[#2F7D55]"></span>
                </div>

                <div id="roleBadge" class="hidden bg-white text-gray-600 px-4 py-2 rounded-2xl border border-gray-100 text-sm">
                    Role:
                    <span id="roleBadgeText" class="font-bold text-[#2F7D55]"></span>
                </div>

            </div>

        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-gray-100">

            <table class="w-full min-w-[1350px]">

                <thead class="bg-[#4D9A72] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            NIP
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Role
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Siswa
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Status Password
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Reset Password
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white" id="akunTableBody">

                    @forelse($users as $user)

                        <tr class="hover:bg-[#FAFCFB] transition akun-row"
                            data-name="{{ strtolower($user->name) }}"
                            data-email="{{ strtolower($user->email) }}"
                            data-nip="{{ strtolower($user->nip ?? '') }}"
                            data-role="{{ $user->role }}">

                            <!-- NAMA -->
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
                                            User aktif
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <!-- EMAIL -->
                            <td class="px-6 py-5 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <!-- NIP -->
                            <td class="px-6 py-5 text-gray-600">
                                {{ $user->nip ?? '-' }}
                            </td>

                            <!-- ROLE -->
                            <td class="px-6 py-5">
                                @if($user->role == 'admin')
                                    <span class="px-4 py-2 rounded-2xl text-sm font-bold bg-purple-100 text-purple-700">
                                        Admin
                                    </span>
                                @elseif($user->role == 'guru')
                                    <span class="px-4 py-2 rounded-2xl text-sm font-bold bg-blue-100 text-blue-700">
                                        Guru
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-2xl text-sm font-bold bg-[#EEF7F1] text-[#2F7D55]">
                                        Orang Tua
                                    </span>
                                @endif
                            </td>

                            <!-- SISWA -->
                            <td class="px-6 py-5 text-gray-600">
                                @if($user->siswa)
                                    <div>
                                        <p class="font-semibold text-[#1F252D]">
                                            {{ $user->siswa->nama }}
                                        </p>

                                        <p class="text-sm text-gray-400">
                                            NIS: {{ $user->siswa->nis }}
                                        </p>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>

                            <!-- STATUS PASSWORD -->
                            <td class="px-6 py-5">
                                @if($user->must_change_password)
                                    <span class="px-4 py-2 rounded-2xl text-sm font-bold bg-yellow-100 text-yellow-700">
                                        Belum diganti
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-2xl text-sm font-bold bg-green-100 text-green-700">
                                        Sudah diganti
                                    </span>
                                @endif
                            </td>

                            <!-- RESET PASSWORD -->
                            <td class="px-6 py-5">
                                <form method="POST"
                                      action="{{ route('admin.akun.reset-password', $user->id) }}"
                                      class="reset-password-form flex items-center gap-2">

                                    @csrf

                                    <input type="text"
                                           name="password_baru"
                                           placeholder="Password baru"
                                           value="password123"
                                           class="w-40 px-4 py-2 border border-gray-200 rounded-xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">

                                    <button type="submit"
                                            class="bg-[#EEF7F1] text-[#2F7D55] px-4 py-2 rounded-xl hover:bg-[#DDF3E7] transition font-bold">
                                        Reset
                                    </button>

                                </form>
                            </td>

                            <!-- AKSI HAPUS -->
                            <td class="px-6 py-5 text-center">

                                <form action="{{ route('admin.akun.destroy', $user->id) }}"
                                      method="POST"
                                      class="delete-user-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-100 text-red-700 px-4 py-2 rounded-xl hover:bg-red-200 transition font-bold">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                Belum ada akun.
                            </td>
                        </tr>

                    @endforelse

                    <!-- EMPTY RESULT LIVE SEARCH -->
                    <tr id="emptySearchRow" class="hidden">
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada akun yang cocok dengan pencarian/filter.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    // TOGGLE FIELD ROLE
    const roleSelect = document.getElementById('role');
    const siswaWrapper = document.getElementById('siswa-wrapper');
    const nipWrapper = document.getElementById('nip-wrapper');

    function toggleRoleFields() {
        if (!roleSelect) return;

        if (roleSelect.value === 'orangtua') {
            siswaWrapper.style.display = 'block';
        } else {
            siswaWrapper.style.display = 'none';
        }

        if (roleSelect.value === 'guru') {
            nipWrapper.style.display = 'block';
        } else {
            nipWrapper.style.display = 'none';
        }
    }

    if (roleSelect && siswaWrapper && nipWrapper) {
        roleSelect.addEventListener('change', toggleRoleFields);
        toggleRoleFields();
    }

    // LIVE SEARCH AKUN
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const resetFilter = document.getElementById('resetFilter');
    const akunRows = document.querySelectorAll('.akun-row');
    const jumlahAkun = document.getElementById('jumlahAkun');
    const totalAkunDisplay = document.getElementById('totalAkunDisplay');
    const emptySearchRow = document.getElementById('emptySearchRow');

    const filterInfo = document.getElementById('filterInfo');
    const searchBadge = document.getElementById('searchBadge');
    const searchBadgeText = document.getElementById('searchBadgeText');
    const roleBadge = document.getElementById('roleBadge');
    const roleBadgeText = document.getElementById('roleBadgeText');

    function getRoleLabel(role) {
        if (role === 'admin') return 'Admin';
        if (role === 'guru') return 'Guru';
        if (role === 'orangtua') return 'Orang Tua';
        return '';
    }

    function filterAkun() {
        const keyword = searchInput.value.toLowerCase().trim();
        const selectedRole = roleFilter.value;
        let totalTampil = 0;

        akunRows.forEach(function(row) {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            const nip = row.dataset.nip || '';
            const role = row.dataset.role || '';

            const cocokSearch =
                keyword === '' ||
                name.includes(keyword) ||
                email.includes(keyword) ||
                nip.includes(keyword);

            const cocokRole = selectedRole === '' || role === selectedRole;

            if (cocokSearch && cocokRole) {
                row.style.display = '';
                totalTampil++;
            } else {
                row.style.display = 'none';
            }
        });

        if (jumlahAkun) {
            jumlahAkun.textContent = totalTampil;
        }

        if (totalAkunDisplay) {
            totalAkunDisplay.textContent = totalTampil;
        }

        if (emptySearchRow) {
            if (totalTampil === 0 && akunRows.length > 0) {
                emptySearchRow.classList.remove('hidden');
            } else {
                emptySearchRow.classList.add('hidden');
            }
        }

        if (keyword !== '' || selectedRole !== '') {
            filterInfo.classList.remove('hidden');

            if (keyword !== '') {
                searchBadge.classList.remove('hidden');
                searchBadgeText.textContent = keyword;
            } else {
                searchBadge.classList.add('hidden');
            }

            if (selectedRole !== '') {
                roleBadge.classList.remove('hidden');
                roleBadgeText.textContent = getRoleLabel(selectedRole);
            } else {
                roleBadge.classList.add('hidden');
            }
        } else {
            filterInfo.classList.add('hidden');
            searchBadge.classList.add('hidden');
            roleBadge.classList.add('hidden');
        }
    }

    if (searchInput && roleFilter && resetFilter) {
        searchInput.addEventListener('input', filterAkun);
        roleFilter.addEventListener('change', filterAkun);

        resetFilter.addEventListener('click', function() {
            searchInput.value = '';
            roleFilter.value = '';
            filterAkun();
        });
    }

    // KONFIRMASI RESET PASSWORD
    document.querySelectorAll('.reset-password-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Reset Password?',
                text: 'Password user akan direset dan user wajib mengganti password saat login berikutnya.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2F7D55',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // KONFIRMASI HAPUS AKUN
    document.querySelectorAll('.delete-user-form').forEach(function(form) {
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
