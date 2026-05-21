<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMukmin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f3f3f3;
            font-family: Arial, sans-serif;
        }

        /* NAVBAR */

        .navbar-custom{
            background: #4f9b72;
            padding: 15px 0;
        }

        .navbar-brand{
            font-size: 35px;
            font-weight: bold;
            color: white !important;
        }

        .nav-link{
            color: white !important;
            font-size: 18px;
            margin-right: 10px;
        }

        .btn-login-nav{
            background: white;
            color: #4f9b72;
            border-radius: 12px;
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
        }

        /* MAIN */

        .main{
            padding: 120px 40px 40px 40px;
        }

        /* HERO */

        .hero-card{
            background: white;
            border-radius: 35px;
            padding: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .hero-card h1{
            font-size: 60px;
            font-weight: bold;
        }

        .hero-card p{
            font-size: 24px;
            color: gray;
        }

        .btn-login{
            background: #2e8b57;
            color: white;
            padding: 15px 35px;
            border-radius: 15px;
            border: none;
            text-decoration: none;
            font-size: 20px;
            display: inline-block;
            margin-top: 20px;
        }

        /* CARD */

        .info-card{
            background: white;
            padding: 35px;
            border-radius: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            height: 100%;
            transition: 0.3s;
        }

        .info-card:hover{
            transform: translateY(-5px);
        }

        .info-card h2{
            color: #2e8b57;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* MAP */

        .map-card{
            background: white;
            padding: 30px;
            border-radius: 25px;
            margin-top: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        footer{
            text-align: center;
            padding: 30px;
            color: gray;
        }

    </style>

</head>
<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">

    <div class="container">

        <a class="navbar-brand" href="#">
            SiMukmin
        </a>

        <button class="navbar-toggler bg-light"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="#home">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tentang">
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#fitur">
                        Fitur
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#lokasi">
                        Lokasi
                    </a>
                </li>

                <li class="nav-item ms-3">
                    <a href="/login" class="btn-login-nav">
                        Login
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>

<!-- MAIN -->

<div class="main">

    <!-- HERO -->

    <section id="home">

        <div class="hero-card">

            <div class="row align-items-center">

                <div class="col-md-7">

                    <h1>Selamat Datang</h1>

                    <p>
                        Website monitoring siswa, absensi, dan laporan perkembangan siswa SDIT Mukmin.
                    </p>

                    <a href="/login" class="btn-login">
                        Login Sekarang
                    </a>

                </div>

                <div class="col-md-5 text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                        class="img-fluid"
                        width="250"
                    >

                </div>

            </div>

        </div>

    </section>

    <!-- TENTANG -->

    <section id="tentang" class="mt-5">

        <div class="row g-4">

            <div class="col-md-6">

                <div class="info-card">

                    <h2>Tentang Sekolah</h2>

                    <p>
                        SDIT Mukmin merupakan sekolah yang memanfaatkan teknologi
                        untuk membantu monitoring aktivitas siswa, absensi,
                        dan perkembangan ibadah siswa.
                    </p>

                </div>

            </div>

            <div class="col-md-6">

                <div class="info-card">

                    <h2>Visi Sekolah</h2>

                    <p>
                        Menjadi sekolah islami yang unggul dalam pendidikan,
                        teknologi, dan pembentukan karakter siswa.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- FITUR -->

    <section id="fitur" class="mt-5">

        <div class="row g-4">

            <div class="col-md-4">

                <div class="info-card">

                    <h2>Monitoring</h2>

                    <p>
                        Memantau aktivitas dan perkembangan siswa setiap hari.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="info-card">

                    <h2>Rekap Absensi</h2>

                    <p>
                        Mengelola kehadiran siswa dengan mudah dan cepat.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="info-card">

                    <h2>Prestasi</h2>

                    <p>
                        Mencatat laporan prestasi dan pelanggaran siswa.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- LOKASI -->

    <section id="lokasi" class="mt-5">

        <div class="map-card">

            <h2 class="mb-4">
                Lokasi Sekolah
            </h2>

            <div class="ratio ratio-16x9">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9142682603892!2d107.53936927356939!3d-7.019363292982242!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ec25cb176fa5%3A0x2b32068416c0bbf4!2sSDIT%20Mukmin%20Kreatif!5e0!3m2!1sid!2sid!4v1779343491169!5m2!1sid!2sid"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

            </div>

        </div>

    </section>

</div>

<!-- FOOTER -->

<footer>
    © 2026 SiMukmin - Sistem Informasi Sekolah
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>