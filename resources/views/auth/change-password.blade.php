<x-guest-layout>

    <div class="text-center mb-8">

        <div class="w-16 h-16 mx-auto rounded-3xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-5">
            S
        </div>

        <h1 class="text-3xl font-bold text-[#1F252D]">
            Ganti Password
        </h1>

        <p class="text-gray-500 mt-3 leading-relaxed">
            Untuk keamanan akun, silakan ganti password default terlebih dahulu.
        </p>

    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-100 text-red-700 px-5 py-4 rounded-2xl">

            <p class="font-semibold mb-2">
                Data belum sesuai:
            </p>

            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 bg-[#EEF7F1] border border-[#DDF3E7] text-[#2F7D55] px-5 py-4 rounded-2xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.change.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">
                Password Baru
            </label>

            <input id="password"
                   type="password"
                   name="password"
                   required
                   autofocus
                   placeholder="Masukkan password baru"
                   class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">

            <p class="text-xs text-gray-400 mt-2">
                Gunakan password yang mudah diingat tetapi sulit ditebak.
            </p>
        </div>

        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-700">
                Konfirmasi Password Baru
            </label>

            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   placeholder="Ulangi password baru"
                   class="w-full px-5 py-4 border border-gray-200 rounded-2xl bg-[#FAFCFB] focus:outline-none focus:ring-2 focus:ring-[#4D9A72] focus:border-transparent">
        </div>

        <button type="submit"
                class="w-full bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-4 rounded-2xl font-bold transition shadow-sm">
            Simpan Password
        </button>

    </form>

    <div class="mt-8 text-center">

        <p class="text-sm text-gray-500">
            Setelah password berhasil diganti, kamu akan diarahkan ke dashboard.
        </p>

    </div>

</x-guest-layout>
