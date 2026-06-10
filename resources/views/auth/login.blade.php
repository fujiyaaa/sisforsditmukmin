<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiMukmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f7f5;
            font-family: Arial, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            width: 900px;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(31, 95, 67, 0.12);
            border: 1px solid #eef2ef;
        }

        .left-side {
            background: linear-gradient(135deg, #1F5F43, #2F7D55, #75C295);
            color: white;
            padding: 45px;
            min-height: 560px;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }

        .left-side::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(221, 243, 231, 0.18);
            border-radius: 50%;
            bottom: -70px;
            left: -70px;
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        .brand-badge {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 24px;
        }

        .logo-box {
            width: 90px;
            height: 90px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .left-side h1 {
            font-size: 44px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .left-side p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.7;
            margin-bottom: 0;
        }

        .login-info {
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.13);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 24px;
            padding: 20px;
            text-align: left;
        }

        .login-info p {
            font-size: 14px;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.88);
        }

        .login-info p:last-child {
            margin-bottom: 0;
        }

        .right-side {
            padding: 50px;
        }

        .right-side h2 {
            font-size: 40px;
            font-weight: 800;
            color: #1F252D;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 32px;
        }

        .form-label {
            font-weight: 700;
            margin-bottom: 8px;
            color: #374151;
        }

        .form-control {
            height: 52px;
            border-radius: 16px;
            border: 1px solid #d9e3dd;
            box-shadow: none;
            padding-left: 16px;
            background: #FAFCFB;
        }

        .form-control:focus {
            border-color: #4D9A72;
            box-shadow: 0 0 0 4px rgba(77, 154, 114, 0.12);
            background: white;
        }

        .input-help {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 7px;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 16px;
            background: #2F7D55;
            color: white;
            font-size: 16px;
            font-weight: 800;
            margin-top: 12px;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #256B47;
            transform: translateY(-1px);
        }

        .form-check-input:checked {
            background-color: #2F7D55;
            border-color: #2F7D55;
        }

        .register-link {
            color: #2F7D55;
            text-decoration: none;
            font-weight: 800;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 14px 16px;
            border-radius: 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .login-card {
                width: 100%;
            }

            .left-side {
                min-height: auto;
                padding: 35px;
            }

            .right-side {
                padding: 35px;
            }

            .left-side h1 {
                font-size: 36px;
            }

            .right-side h2 {
                font-size: 34px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="row g-0">

            <!-- LEFT -->
            <div class="col-md-5">

                <div class="left-side d-flex flex-column justify-content-center">

                    <div class="left-content">

                        <div class="brand-badge">
                            SIMUKMIN
                        </div>

                        <div class="logo-box">
                            SM
                        </div>

                        <h1>
                            SiMukmin
                        </h1>

                        <p>
                            Sistem informasi monitoring siswa, absensi, ibadah sholat,
                            setoran Quran, dan perkembangan siswa SDIT Mukmin Kreatif.
                        </p>

                        <div class="login-info">
                            
                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-md-7">

                <div class="right-side">

                    <h2>
                        Login
                    </h2>

                    <p class="subtitle">
                        Masuk ke akun SiMukmin sesuai role pengguna.
                    </p>

                    @if ($errors->any())
                        <div class="error-box">
                            @foreach ($errors->all() as $error)
                                <div>
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success rounded-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">

                        @csrf

                        <!-- LOGIN FIELD -->
                        <div class="mb-3">

                            <label for="email" class="form-label">
                                Email / NIP / NIS
                            </label>

                            <input
                                id="email"
                                type="text"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="Email admin / NIP guru / NIS siswa"
                                required
                                autofocus
                                autocomplete="username"
                            >



                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">

                            <label for="password" class="form-label">
                                Password
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            >

                        </div>

                        <!-- REMEMBER -->
                        <div class="form-check mb-3">

                            <input
                                id="remember_me"
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                            >

                            <label for="remember_me" class="form-check-label">
                                Remember me
                            </label>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn-login">
                            Login
                        </button>

                        <!-- REGISTER -->
                        @if (Route::has('register'))
                        @endif

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#2F7D55',
            confirmButtonText: 'Oke'
        });
    </script>
@endif

</body>
</html>
