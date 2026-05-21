<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SiMukmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f3f3f3;
            font-family: Arial, sans-serif;
        }

        .forgot-container{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .forgot-card{
            width: 850px;
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .left-side{
            background: #4f9b72;
            color: white;
            padding: 40px;
            height: 100%;
        }

        .left-side h1{
            font-size: 42px;
            font-weight: bold;
            margin-top: 20px;
        }

        .left-side p{
            font-size: 16px;
            color: #e5fff0;
        }

        .forgot-image{
            width: 140px;
        }

        .right-side{
            padding: 45px;
        }

        .right-side h2{
            font-size: 36px;
            font-weight: bold;
            color: #2e8b57;
            margin-bottom: 20px;
        }

        .info-text{
            color: #666;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .form-label{
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control{
            height: 48px;
            border-radius: 12px;
            border: 1px solid #ccc;
            box-shadow: none;
        }

        .form-control:focus{
            border-color: #4f9b72;
            box-shadow: none;
        }

        .btn-reset{
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: #2e8b57;
            color: white;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn-reset:hover{
            background: #256f46;
        }

        .login-link{
            color: #2e8b57;
            text-decoration: none;
            font-weight: bold;
        }

    </style>

</head>
<body>

<div class="forgot-container">

    <div class="forgot-card">

        <div class="row g-0">

            <!-- LEFT -->

            <div class="col-md-5">

                <div class="left-side d-flex flex-column justify-content-center align-items-center text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png"
                        class="forgot-image"
                    >

                    <h1>SiMukmin</h1>

                    <p>
                        Reset password untuk kembali mengakses
                        sistem informasi sekolah.
                    </p>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-md-7">

                <div class="right-side">

                    <h2>Lupa Password</h2>

                    <p class="info-text">
                        Masukkan email akun Anda dan kami akan
                        mengirimkan link reset password.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">

                        @csrf

                        <!-- EMAIL -->

                        <div class="mb-4">

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

                        <!-- BUTTON -->

                        <button type="submit" class="btn-reset">
                            Kirim Link Reset Password
                        </button>

                        <!-- LOGIN -->

                        <div class="text-center mt-4">

                            Sudah ingat password?

                            <a href="{{ route('login') }}"
                               class="login-link">

                                Login

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>