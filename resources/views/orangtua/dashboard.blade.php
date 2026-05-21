<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f3f3f3;
            font-family:Arial,sans-serif;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:#4f9b72;
            position:fixed;
            left:0;
            top:0;
            padding:30px;
            color:white;
        }

        .sidebar h2{
            font-weight:bold;
            margin-bottom:40px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:15px;
            border-radius:12px;
            margin-bottom:10px;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,0.15);
        }

        .main{
            margin-left:270px;
            padding:30px;
        }

        .card-custom{
            background:white;
            border-radius:20px;
            padding:30px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

    </style>

</head>
<body>

<div class="sidebar">

    <h2>SiMukmin</h2>

    <a href="#">
        Dashboard
    </a>

    <a href="#">
        Monitoring Anak
    </a>

    <a href="#">
        Rekap Absensi
    </a>

    <a href="#">
        Prestasi Anak
    </a>

</div>

<div class="main">

    <div class="card-custom">

        <h1>Dashboard Orang Tua</h1>

        <p class="text-muted mt-3">
            Selamat datang di sistem monitoring siswa.
        </p>

    </div>

</div>

</body>
</html>