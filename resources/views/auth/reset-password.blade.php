<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SiMukmin</title>

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
            width:550px;
            background:white;
            border-radius:25px;
            padding:40px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

        h2{
            color:#2e8b57;
            font-weight:bold;
            margin-bottom:25px;
        }

        .form-control{
            height:48px;
            border-radius:12px;
        }

        .btn-reset{
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

        <h2>Reset Password</h2>

        <form method="POST" action="{{ route('password.store') }}">

            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    required
                >

            </div>

            <button type="submit" class="btn-reset">
                Reset Password
            </button>

        </form>

    </div>

</div>

</body>
</html>