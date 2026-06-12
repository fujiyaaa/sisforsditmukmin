<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMukmin</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F4F7F5] text-[#1F252D] font-sans">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#1F6B4A]/95 backdrop-blur-md border-b border-white/10">

        <div class="max-w-6xl mx-auto px-5 lg:px-6">

            <div class="flex items-center justify-between h-16">

                <a href="#home" class="flex items-center gap-3">

                   <div class="w-12 h-12 shrink-0 flex items-center justify-center rounded-2xl bg-black/10 overflow-hidden p-1">
                            <img src="{{ asset('images/logo.png') }}"
                                alt="Logo SiMukmin"
                                class="w-full h-full object-contain mix-blend-screen">
                        </div>

                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">
                            SiMukmin
                        </h1>

                        <p class="text-[11px] text-white/60">
                            Sistem Informasi Sekolah
                        </p>
                    </div>

                </a>

                <div class="hidden md:flex items-center gap-1">

                    <a href="#home"
                       class="px-4 py-2 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition text-sm font-medium">
                        Beranda
                    </a>

                    <a href="#tentang"
                       class="px-4 py-2 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition text-sm font-medium">
                        Tentang
                    </a>

                    <a href="#fitur"
                       class="px-4 py-2 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition text-sm font-medium">
                        Fitur
                    </a>

                    <a href="#lokasi"
                       class="px-4 py-2 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition text-sm font-medium">
                        Lokasi
                    </a>

                    <a href="{{ url('/login') }}"
                       class="ml-3 inline-flex items-center justify-center bg-white text-[#1F6B4A] hover:bg-[#F0F8F4] px-5 py-2.5 rounded-xl font-bold text-sm transition shadow-sm">
                        Login
                    </a>

                </div>

                <a href="{{ url('/login') }}"
                   class="md:hidden inline-flex items-center justify-center bg-white text-[#1F6B4A] px-4 py-2 rounded-xl font-bold text-sm">
                    Login
                </a>

            </div>

        </div>

    </nav>

    {{-- MAIN --}}
    <main class="pt-20">

        {{-- HERO --}}
        <section id="home" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#1F6B4A] via-[#2F7D55] to-[#4D9A72] p-7 md:p-9 lg:p-10 shadow-sm">

                <div class="absolute -right-24 -top-24 w-80 h-80 rounded-full bg-white/10"></div>
                <div class="absolute -left-20 -bottom-24 w-64 h-64 rounded-full bg-white/10"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

                    <div>

                        <p class="inline-flex items-center bg-white/15 text-white text-[11px] tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-5">
                            SDIT MUKMIN KREATIF
                        </p>

                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                            Selamat Datang di SiMukmin
                        </h1>

                        <p class="text-white/90 text-base md:text-lg mt-4 leading-relaxed max-w-xl">
                            Website monitoring aktivitas siswa, absensi, ibadah, setoran Quran, serta laporan perkembangan siswa SDIT Mukmin Kreatif.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3 mt-6">

                            <a href="{{ url('/login') }}"
                               class="inline-flex items-center justify-center bg-white text-[#1F6B4A] hover:bg-[#F0F8F4] px-6 py-3 rounded-2xl font-bold text-sm transition shadow-sm">
                                Login Sekarang
                            </a>

                            <a href="#fitur"
                               class="inline-flex items-center justify-center bg-white/10 text-white hover:bg-white/20 px-6 py-3 rounded-2xl font-bold text-sm transition border border-white/10">
                                Lihat Fitur
                            </a>

                        </div>

                    </div>

                    <div class="flex justify-center lg:justify-end">

                        <div class="bg-white/15 backdrop-blur-sm border border-white/10 rounded-[2rem] p-5 w-full max-w-sm">

                            <div class="bg-white rounded-[1.5rem] p-6 shadow-sm">

                                <div class="w-16 h-16 rounded-2xl bg-[#DDF3E7] text-[#2F7D55] flex items-center justify-center text-2xl font-bold mb-4">
                                    S
                                </div>

                                <h2 class="text-xl font-bold text-[#1F252D]">
                                    Monitoring Terintegrasi
                                </h2>

                                <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                                    Guru dan orang tua dapat memantau perkembangan siswa melalui satu sistem yang rapi dan mudah digunakan.
                                </p>

                                <div class="grid grid-cols-2 gap-3 mt-5">

                                    <div class="rounded-2xl bg-[#F6FAF8] border border-[#E6F4EC] p-4">
                                        <p class="text-xs text-gray-500">Role</p>
                                        <h3 class="text-lg font-bold text-[#2F7D55] mt-1">
                                            3
                                        </h3>
                                    </div>

                                    <div class="rounded-2xl bg-[#F6FAF8] border border-[#E6F4EC] p-4">
                                        <p class="text-xs text-gray-500">Fitur</p>
                                        <h3 class="text-lg font-bold text-[#2F7D55] mt-1">
                                            5+
                                        </h3>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        {{-- TENTANG --}}
        <section id="tentang" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

                    <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold mb-5">
                        T
                    </div>

                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Tentang Sekolah
                    </h2>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        SDIT Mukmin Kreatif merupakan sekolah yang memanfaatkan teknologi untuk membantu monitoring aktivitas siswa, absensi, ibadah, dan perkembangan siswa secara lebih terstruktur.
                    </p>

                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

                    <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold mb-5">
                        V
                    </div>

                    <h2 class="text-2xl font-bold text-[#1F252D]">
                        Visi Sekolah
                    </h2>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Menjadi sekolah islami yang unggul dalam pendidikan, teknologi, dan pembentukan karakter siswa yang berakhlak baik.
                    </p>

                </div>

            </div>

        </section>

        {{-- FITUR --}}
        <section id="fitur" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="mb-6">

                <p class="inline-flex items-center bg-[#EEF7F1] text-[#2F7D55] text-[11px] tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-4">
                    FITUR UTAMA
                </p>

                <h2 class="text-3xl md:text-4xl font-bold text-[#1F252D]">
                    Fitur Sistem SiMukmin
                </h2>

                <p class="text-gray-500 mt-3 max-w-2xl text-sm leading-relaxed">
                    Sistem ini dirancang untuk membantu guru dan orang tua dalam memantau kegiatan siswa secara praktis.
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-1 transition">

                    <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold mb-5">
                        M
                    </div>

                    <h3 class="text-lg font-bold text-[#1F252D]">
                        Monitoring Ibadah
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Memantau sholat fardhu siswa berdasarkan input guru dan orang tua.
                    </p>

                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-1 transition">

                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-5">
                        A
                    </div>

                    <h3 class="text-lg font-bold text-[#1F252D]">
                        Rekap Absensi
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Mengelola kehadiran, izin, sakit, alpha, dan keterlambatan siswa.
                    </p>

                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-1 transition">

                    <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold mb-5">
                        Q
                    </div>

                    <h3 class="text-lg font-bold text-[#1F252D]">
                        Setoran Quran
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Mencatat setoran Tahfidz, Murajaah, dan Tilawah siswa.
                    </p>

                </div>

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-1 transition">

                    <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-bold mb-5">
                        L
                    </div>

                    <h3 class="text-lg font-bold text-[#1F252D]">
                        Laporan Siswa
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Mencatat laporan prestasi, pelanggaran, dan informasi siswa.
                    </p>

                </div>

            </div>

        </section>

        {{-- LOKASI --}}
        <section id="lokasi" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">

                <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <p class="inline-flex items-center bg-[#EEF7F1] text-[#2F7D55] text-[11px] tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-4">
                            LOKASI
                        </p>

                        <h2 class="text-2xl font-bold text-[#1F252D]">
                            Lokasi Sekolah
                        </h2>

                        <p class="text-gray-500 mt-2 text-sm">
                            SDIT Mukmin Kreatif.
                        </p>
                    </div>

                    <a href="{{ url('/login') }}"
                       class="inline-flex items-center justify-center bg-[#2F7D55] hover:bg-[#256B47] text-white px-6 py-3 rounded-2xl font-semibold text-sm transition shadow-sm">
                        Masuk ke Sistem
                    </a>

                </div>

                <div class="w-full h-[340px] bg-gray-100">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9142682603892!2d107.53936927356939!3d-7.019363292982242!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ec25cb176fa5%3A0x2b32068416c0bbf4!2sSDIT%20Mukmin%20Kreatif!5e0!3m2!1sid!2sid!4v1779343491169!5m2!1sid!2sid"
                        class="w-full h-full border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>

            </div>

        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="mt-6 border-t border-gray-100 bg-white">

        <div class="max-w-6xl mx-auto px-5 lg:px-6 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <p class="text-gray-500 text-sm">
                © 2026 SiMukmin - Sistem Informasi Sekolah
            </p>

            <div class="flex items-center gap-3">

                <span class="w-2.5 h-2.5 rounded-full bg-[#2F7D55]"></span>

                <p class="text-sm font-semibold text-[#2F7D55]">
                    SDIT Mukmin Kreatif
                </p>

            </div>

        </div>

    </footer>

</body>
</html>
