<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiMukmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f3f3f3;
            font-family: Arial, sans-serif;
        }

        .login-container{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card{
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

        .login-image{
            width: 140px;
        }

        .right-side{
            padding: 45px;
        }

        .right-side h2{
            font-size: 38px;
            font-weight: bold;
            color: #2e8b57;
            margin-bottom: 30px;
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

        .btn-login{
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

        .btn-login:hover{
            background: #256f46;
        }

        .register-link{
            color: #2e8b57;
            text-decoration: none;
            font-weight: bold;
        }

    </style>

</head>
<body>

<div class="login-container">

    <div class="login-card">

        <div class="row g-0">

            <!-- LEFT -->

            <div class="col-md-5">

                <div class="left-side d-flex flex-column justify-content-center align-items-center text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                        class="login-image"
                    >

                    <h1>SiMukmin</h1>

                    <p>
                        Sistem informasi monitoring siswa,
                        absensi, dan perkembangan siswa.
                    </p>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-md-7">

                <div class="right-side">

                    <h2>Login</h2>

                    <form method="POST" action="{{ route('login') }}">

                        @csrf

                        <!-- EMAIL -->

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

                        <!-- PASSWORD -->

                        <div class="mb-3">

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

                        <!-- REMEMBER -->

                        <div class="form-check mb-3">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                            >

                            <label class="form-check-label">
                                Remember me
                            </label>

                        </div>

                        <!-- BUTTON -->

                        <button type="submit" class="btn-login">
                            Login
                        </button>

                        <!-- REGISTER -->

                        <div class="text-center mt-4">

                            Belum punya akun?

                            <a href="{{ route('register') }}"
                               class="register-link">

                                Register

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