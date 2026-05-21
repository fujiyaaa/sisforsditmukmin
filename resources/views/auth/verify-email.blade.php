<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - SiMukmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f3f3f3;
            font-family:Arial,sans-serif;
        }

        .container-box{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .card-box{
            width:600px;
            background:white;
            border-radius:25px;
            padding:45px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
            text-align:center;
        }

        h2{
            color:#2e8b57;
            font-weight:bold;
            margin-bottom:20px;
        }

        .btn-verify{
            width:100%;
            height:48px;
            border:none;
            border-radius:12px;
            background:#2e8b57;
            color:white;
            font-weight:bold;
            margin-top:20px;
        }

        .logout-link{
            display:block;
            margin-top:20px;
            color:#2e8b57;
            text-decoration:none;
            font-weight:bold;
        }

    </style>

</head>
<body>

<div class="container-box">

    <div class="card-box">

        <h2>Verifikasi Email</h2>

        <p class="text-muted">
            Terima kasih telah mendaftar.
            Silakan cek email Anda untuk melakukan verifikasi akun.
        </p>

        @if (session('status') == 'verification-link-sent')

            <div class="alert alert-success mt-3">

                Link verifikasi baru berhasil dikirim.

            </div>

        @endif

        <form method="POST" action="{{ route('verification.send') }}">

            @csrf

            <button type="submit" class="btn-verify">
                Kirim Ulang Email Verifikasi
            </button>

        </form>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="btn btn-link logout-link">

                Logout

            </button>

        </form>

    </div>

</div>

</body>
</html>