<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password - SiMukmin</title>

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
            width:500px;
            background:white;
            border-radius:25px;
            padding:40px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

        h2{
            color:#2e8b57;
            font-weight:bold;
            margin-bottom:20px;
        }

        .form-control{
            height:48px;
            border-radius:12px;
        }

        .btn-confirm{
            width:100%;
            height:48px;
            border:none;
            border-radius:12px;
            background:#2e8b57;
            color:white;
            font-weight:bold;
        }

    </style>

</head>
<body>

<div class="container-box">

    <div class="card-box">

        <h2>Konfirmasi Password</h2>

        <p class="text-muted mb-4">
            Silakan masukkan password Anda untuk melanjutkan akses.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">

            @csrf

            <div class="mb-4">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

            </div>

            <button type="submit" class="btn-confirm">
                Konfirmasi Password
            </button>

        </form>

    </div>

</div>

</body>
</html>