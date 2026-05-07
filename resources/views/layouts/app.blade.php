<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SiMukmin</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#F3F3F3] font-sans">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-[#4D9A72] text-white flex flex-col justify-between shadow-2xl">

        <div>

            <!-- LOGO -->
            <div class="p-6 border-b border-white/10">

                <h1 class="text-4xl font-bold">
                    SiMukmin
                </h1>

                <p class="text-sm text-white/80 mt-1">
                    Panel Guru
                </p>

            </div>

            <!-- NAVBAR -->
            <nav class="mt-8 px-4 space-y-3">

                <a href="/dashboard-guru"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>🏠</span>
                    <span>Dashboard</span>

                </a>


                <a href="/guru/monitoring"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>🕌</span>
                    <span>Monitoring</span>

                </a>

                <a href="/guru/absensi"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>📋</span>
                    <span>Absensi</span>

                </a>

                <a href="/guru/hafalan"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-white/10 transition">

                    <span>📖</span>
                    <span>Hafalan Qur'an</span>

                </a>

            </nav>

        </div>

        <!-- PROFILE -->
        <div class="p-4">

            <div class="bg-[#2F6F4F] rounded-2xl p-5">

                <h2 class="font-bold text-lg">
                    {{ Auth::user()->name ?? 'Guru' }}
                </h2>

                <p class="text-sm text-white/70 mt-1">
                    Dashboard Guru
                </p>

            </div>

        </div>

    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-8">

        @yield('content')

    </main>

</div>

</body>
</html>