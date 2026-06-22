<!DOCTYPE html>
<html lang="id">
<head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
        }
    </style>
</head>

<body class="bg-slate-950 text-white overflow-x-hidden">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-slate-950/70 border-b border-white/10">

        <div class="max-w-6xl mx-auto px-5 lg:px-6">

            <div class="flex items-center justify-between h-16">

                <a href="#home" class="flex items-center gap-3">

<<<<<<< HEAD
=======
                   <div class="w-12 h-12 shrink-0 flex items-center justify-center rounded-2xl bg-black/10 overflow-hidden p-1">
                            <img src="{{ asset('images/logo.png') }}"
                                alt="Logo SiMukmin"
                                class="w-full h-full object-contain mix-blend-screen">
                        </div>

>>>>>>> f83cb3209145c42b8efbbefaacab331c5313c251
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">
                            MUKTI
                        </h1>

                        <p class="text-xs text-white/60">
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
                       class="bg-emerald-500 hover:bg-emerald-400 text-white px-5 py-2.5 rounded-xl font-semibold transition">
                        Login
                    </a>

                </div>

                <a href="{{ url('/login') }}"
                   class="md:hidden inline-flex items-center justify-center bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2 rounded-xl font-semibold transition">
                    Login
                </a>

            </div>

        </div>

    </nav>

    {{-- MAIN --}}
    <main class="pt-20">

        {{-- HERO --}}
        <section id="home" class="relative min-h-screen flex items-center">

    <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-slate-950 to-slate-900"></div>

    <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/20 blur-[120px] rounded-full"></div>

    <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-400/20 blur-[120px] rounded-full"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">

        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <div>
                <img
                        src="{{ asset('images/logoSDITMUKMIN.png') }}"
                        alt="Logo SiMukmin"
                        class="w-50 h-50 object-contain"/>

                <span class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-400/20 text-emerald-300 text-sm">
                    ✨ Sistem Monitoring SD  IT Mukmin Kreatif
                </span>

                <h1 class="mt-8 text-5xl lg:text-7xl font-extrabold leading-tight">
                    Monitoring
                    <span class="text-emerald-400">
                        Ibadah,
                    </span>
                    Hafalan &
                    Kehadiran Siswa
                </h1>

                <p class="mt-6 text-slate-300 text-lg leading-relaxed max-w-xl">
                    MUKTI membantu sekolah, guru dan orang tua memantau perkembangan siswa secara real-time dalam satu platform modern.
                </p>


                <div class="flex gap-4 mt-10">
                    <center>
                    <a href="{{ url('/login') }}"
                        class="bg-emerald-500 hover:bg-emerald-400 px-7 py-4 rounded-2xl font-semibold transition">
                        Login Sekarang
                    </a>

                    <a href="#fitur"
                        class="border border-white/10 bg-white/5 px-7 py-4 rounded-2xl font-semibold hover:bg-white/10 transition">
                        Lihat Fitur
                    </a>
                    </center>

                </div>

            </div>

            <div>

                <div class="bg-white/5 border border-white/10 backdrop-blur-xl rounded-3xl p-6">

                    <div class="bg-slate-900 rounded-3xl p-6">

                        <div class="flex items-center justify-between">

                            <h3 class="font-bold text-xl">
                                Dashboard MUKTI
                            </h3>

                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                                Online
                            </span>

                        </div>

                        <div class="space-y-4 mt-6">

                            <div class="bg-emerald-500/10 p-4 rounded-2xl">
                                Monitoring Ibadah
                            </div>

                            <div class="bg-blue-500/10 p-4 rounded-2xl">
                                Absensi Siswa
                            </div>

                            <div class="bg-yellow-500/10 p-4 rounded-2xl">
                                Setoran Quran
                            </div>

                            <div class="bg-red-500/10 p-4 rounded-2xl">
                                Laporan Siswa
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">

    <div class="grid md:grid-cols-4 gap-5">

        <div class="bg-slate-900 border border-white/10 rounded-3xl p-6">
            <h2 class="text-4xl font-bold text-emerald-400">500+</h2>
            <p class="text-slate-400 mt-2">Siswa Aktif</p>
        </div>

        <div class="bg-slate-900 border border-white/10 rounded-3xl p-6">
            <h2 class="text-4xl font-bold text-blue-400">50+</h2>
            <p class="text-slate-400 mt-2">Guru</p>
        </div>

        <div class="bg-slate-900 border border-white/10 rounded-3xl p-6">
            <h2 class="text-4xl font-bold text-yellow-400">95%</h2>
            <p class="text-slate-400 mt-2">Kehadiran</p>
        </div>

        <div class="bg-slate-900 border border-white/10 rounded-3xl p-6">
            <h2 class="text-4xl font-bold text-red-400">24/7</h2>
            <p class="text-slate-400 mt-2">Monitoring</p>
        </div>

    </div>

</section>

        </section>

        {{-- TENTANG --}}

        <section id="tentang" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                <center>
                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                    <h2 class="text-2xl font-bold text-white">
                        Tentang Sekolah
                    </h2>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                         SD IT Mukmin Kreatif hadir sebagai pilihan terbaik bagi orang tua yang ingin memberikan pendidikan berkualitas, yang tidak hanya mencerdaskan pikiran, tetapi juga menumbuhkan karakter mulia pada anak-anak mereka
                    </p>

                </div>
                </center>

                <center>
                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                    <h2 class="text-2xl font-bold text-white">
                        Tentang Sekolah
                    </h2>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                         SD IT Mukmin Kreatif hadir sebagai pilihan terbaik bagi orang tua yang ingin memberikan pendidikan berkualitas, yang tidak hanya mencerdaskan pikiran, tetapi juga menumbuhkan karakter mulia pada anak-anak mereka
                    </p>

                </div>
                </center>


            </div>

        </section>

                {{-- Motto --}}
        <section id="fitur" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="mb-6">

                <center>
                     <h2 class="inline-flex items-center bg-emerald-500/10 text-emerald-400 text-lg font-bold px-6 py-3 rounded-md mb-5">
                     Motto SD IT Mukmin Kreatif
                </h2>

                </center>


            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">


                    <h3 class="text-lg font-bold text-white">
                        SHALEH
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Nilai-nilai ajaran Islam yang terintergasi dalam seluruh muatan kurikulumnya didesign untuk mewujudkan pribadi mukmin unggul yang shaleh, baik dalam hubungan vertikal dengan Allah maupun hubungan horizontal dengan manusia
                    </p>

                </div>

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">


                    <h3 class="text-lg font-bold text-white">
                        BERILMU
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Kurikulum dinas pendidikan yang dikombinasikan dengan kurikulum khas yayasan diramu dalam sebuah pembelajaran yang aktif, inovatif, kreatif, efektif, dan menyenangkan untuk menciptakan peserta didik yang berilmu dan berwawasan luas
                    </p>

                </div>

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">


                    <h3 class="text-lg font-bold text-white">
                        BERKARYA
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Berbagai program yang mengasah sisi kreatifitas disajikan kepada peserta didik agar di masa mendatang mereka tidak hanya menjadi pribadi yang shaleh dan
                        berilmu saja namun juga punya karya nyata bagi masyarakat secara umum
                    </p>

                </div>

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">


                    <h3 class="text-lg font-bold text-white">
                        BERMANFAAT
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        “Sebaik-baik manusia adalah mereka yang paling banyak memberikan manfaat bagi orang lain.” Sabda Nabi Shallallaahu ‘alaihi wasallam inilah yang menjadi goal akhir SDIT Mukmin Kreatif dari setiap proses pendidikan yang dihadirkan kepada masyarakat
                    </p>

                </div>

            </div>

        </section>

        {{-- FITUR --}}
        <section id="fitur" class="max-w-6xl mx-auto px-5 lg:px-6 py-6">

            <div class="mb-6">

                <p class="inline-flex items-center bg-emerald-500/10 text-emerald-400 text-lg font-bold px-6 py-3 rounded-md mb-5">
                    FITUR UTAMA
                </p>

                <h2 class="text-3xl md:text-4xl font-bold text-white">
                    Fitur Sistem MUKTI
                </h2>

                <p class="text-gray-500 mt-3 max-w-2xl text-sm leading-relaxed">
                    Sistem ini dirancang untuk membantu guru dan orang tua dalam memantau kegiatan siswa secara praktis.
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                    <div class="w-12 h-12 rounded-2xl bg-[#EEF7F1] text-[#2F7D55] flex items-center justify-center font-bold mb-5">
                        M
                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Monitoring Ibadah
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Memantau sholat fardhu siswa berdasarkan input guru dan orang tua.
                    </p>

                </div>

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold mb-5">
                        A
                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Rekap Absensi
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Mengelola kehadiran, izin, sakit, alpha, dan keterlambatan siswa.
                    </p>

                </div>

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                    <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold mb-5">
                        Q
                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Setoran Quran
                    </h3>

                    <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                        Mencatat setoran Tahfidz, Murajaah, dan Tilawah siswa.
                    </p>

                </div>

                <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                    <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-bold mb-5">
                        L
                    </div>

                    <h3 class="text-lg font-bold text-white">
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

            <div class="bg-slate-900 border border-white/10 rounded-3xl p-8 hover:border-emerald-400/30 hover:-translate-y-2 transition duration-300">

                <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <p class="inline-flex items-center bg-[#EEF7F1] text-[#2F7D55] text-[11px] tracking-[0.22em] font-bold px-4 py-2 rounded-full mb-4">
                            LOKASI
                        </p>

                        <h2 class="text-2xl font-bold text-white">
                            Lokasi Sekolah
                        </h2>

                        <p class="text-gray-500 mt-2 text-sm">
                            SDIT Mukmin Kreatif.
                        </p>
                    </div>

                    <a href="{{ url('/login') }}"
                       class="bg-emerald-500 hover:bg-emerald-400 text-white px-5 py-2.5 rounded-xl font-semibold transition">
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
                © 2026 MUKTI - Sistem Informasi Sekolah
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
