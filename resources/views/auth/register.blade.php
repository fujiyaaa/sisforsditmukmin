<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SiMukmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f3f3f3;
            font-family: Arial, sans-serif;
        }

        .register-container{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-card{
            width: 900px;
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

        .register-image{
            width: 140px;
        }

        .right-side{
            padding: 40px;
        }

        .right-side h2{
            font-size: 36px;
            font-weight: bold;
            color: #2e8b57;
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

        .btn-register{
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

        .btn-register:hover{
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

<div class="register-container">

    <div class="register-card">

        <div class="row g-0">

            <!-- LEFT -->

            <div class="col-md-5">

                <div class="left-side d-flex flex-column justify-content-center align-items-center text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                        class="register-image"
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

                    <h2>Register</h2>

                    <form method="POST" action="{{ route('register') }}">

                        @csrf

                        <!-- NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required
                            >

                        </div>

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

                        <!-- CONFIRM PASSWORD -->

                        <div class="mb-3">

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

                        <!-- BUTTON -->

                        <button type="submit" class="btn-register">
                            Register
                        </button>

                        <!-- LOGIN -->

                        <div class="text-center mt-4">

                            Sudah punya akun?

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