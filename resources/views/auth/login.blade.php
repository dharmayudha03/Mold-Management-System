<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Mold System Management | PT. IRC INOAC INDONESIA</title>

    <!-- Favicon Logo IRC INOAC -->
    <link rel="icon" type="image/png" href="{{ asset('images/coba.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/coba.png') }}">

    <!-- Local FontAwesome Free CSS & JS SVG Engine (100% Offline Icons) -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" />
    <script src="{{ asset('vendor/fontawesome-free/js/all.min.js') }}"></script>

    <!-- Local SB Admin 2 CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }

        body.login-page {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)),
                        url("{{ asset('images/company_bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 980px;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-section {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.95)),
                        url("{{ asset('images/company_bg.jpg') }}") no-repeat center center;
            background-size: cover;
            padding: 3.5rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100%;
            color: #ffffff;
        }

        .form-section {
            background-color: #ffffff;
            padding: 3.5rem 2.5rem;
        }

        /* Clean Direct Logo & Text (No Capsule/Pill Background) */
        .company-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .brand-coba-logo {
            height: 38px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.4));
        }

        .company-title-text {
            font-size: 0.95rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            color: #ffffff;
            text-transform: uppercase;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
        }

        .app-title {
            font-size: 1.95rem;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: 0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.75rem;
        }

        .custom-input {
            height: 48px !important;
            border-radius: 0.75rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            border: 1px solid #cbd5e1 !important;
            padding-left: 2.75rem !important;
            color: #0f172a !important;
            background-color: #ffffff !important;
        }

        .custom-input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
            outline: none !important;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
            z-index: 10;
        }

        .btn-submit {
            height: 48px;
            border-radius: 0.75rem;
            font-weight: 800;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease-in-out;
            width: 100%;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
            color: #ffffff;
        }

        /* Password Eye Toggle Button */
        .toggle-password-btn {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #64748b;
            padding: 6px 8px;
            font-size: 1rem;
            cursor: pointer;
            z-index: 15;
            transition: color 0.15s ease;
        }

        .toggle-password-btn:hover {
            color: #2563eb;
        }

        @media (max-width: 991.98px) {
            .hero-section {
                padding: 2rem;
            }
            .form-section {
                padding: 2rem 1.5rem;
            }
            .brand-coba-logo {
                height: 38px;
            }
            .company-title-text {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="login-page">

    <div class="login-wrapper">
        <div class="card login-card border-0">
            <div class="row no-gutters">

                <!-- Left Column: Hero & Company Branding -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-section">
                        <div>
                            <!-- Large Prominent Brand Badge with coba.png Logo -->
                            <div class="company-header-badge mb-4">
                                <img src="{{ asset('images/coba.png') }}" alt="Logo IRC" class="brand-coba-logo">
                                <span class="company-title-text">PT. IRC INOAC INDONESIA</span>
                            </div>

                            <div class="mt-2 mb-4">
                                <h1 class="app-title">
                                    MOLD SYSTEM<br>MANAGEMENT
                                </h1>
                                <div style="width: 55px; height: 4px; background: #dc2626; border-radius: 99px;" class="my-3"></div>
                            </div>
                        </div>

                        <div class="my-3">
                            <p class="text-gray-300 text-xs font-weight-semibold mb-0" style="line-height: 1.7;">
                                Sistem informasi terpadu pemantauan mold cetakan, maintenance job order (MJO), setup cetakan, sandblasting, dan riwayat perbaikan secara real-time.
                            </p>
                        </div>

                        <div class="pt-3 border-top border-secondary text-gray-400 text-xs font-weight-bold">
                            &copy; {{ date('Y') }} PT. IRC INOAC INDONESIA. All rights reserved.
                        </div>
                    </div>
                </div>

                <!-- Right Column: Login Form -->
                <div class="col-lg-6">
                    <div class="form-section">
                        <div class="text-center mb-4">
                            <!-- Mobile Company Header -->
                            <div class="d-lg-none mb-3">
                                <div class="company-header-badge d-inline-flex">
                                    <img src="{{ asset('images/coba.png') }}" alt="Logo IRC" class="brand-coba-logo">
                                    <span class="company-title-text" style="color: #0f172a; text-shadow: none;">PT. IRC INOAC INDONESIA</span>
                                </div>
                            </div>
                            <h4 class="font-weight-extrabold text-gray-900 mb-1">Selamat Datang Kembali</h4>
                            <p class="text-xs text-gray-500 font-weight-bold mb-0">Silakan masuk menggunakan akun terdaftar Anda.</p>
                        </div>

                        <!-- Session Status Notification -->
                        @if (session('status'))
                            <div class="alert alert-success border-0 shadow-xs text-xs font-weight-bold mb-3 rounded-lg" role="alert">
                                <i class="fas fa-check-circle mr-1.5"></i> {{ session('status') }}
                            </div>
                        @endif

                        <!-- Error Notification -->
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-xs text-xs font-weight-bold mb-3 rounded-lg" role="alert">
                                <i class="fas fa-exclamation-triangle mr-1.5"></i> Email atau Password yang Anda masukkan salah.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="email" class="text-xs font-weight-extrabold text-gray-800 text-uppercase mb-1 d-block">
                                    Email Address
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                        class="form-control custom-input @error('email') is-invalid @enderror"
                                        placeholder="Masukkan Email Anda">
                                </div>
                            </div>

                            <!-- Password with Show/Hide Toggle Eye Icon -->
                            <div class="form-group mb-3">
                                <label for="password" class="text-xs font-weight-extrabold text-gray-800 text-uppercase mb-1 d-block">
                                    Password
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" id="password" name="password" required autocomplete="current-password"
                                        class="form-control custom-input @error('password') is-invalid @enderror"
                                        placeholder="••••••••" style="padding-right: 3rem !important;">
                                    <button type="button" id="togglePasswordBtn" class="toggle-password-btn" title="Lihat/Sembunyikan Password">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                                    <label class="custom-control-label font-weight-bold text-gray-700 text-xs" for="remember_me">
                                        Ingat Saya
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-weight-bold text-primary text-decoration-none">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk ke Sistem
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top">
                            <span class="text-xs text-gray-400 font-weight-bold">
                                PT. IRC INOAC INDONESIA &copy; {{ date('Y') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Local SB Admin 2 Scripts (100% Offline) -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Password Show/Hide Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                    // Toggle icon between fa-eye and fa-eye-slash
                    const icon = toggleBtn.querySelector('svg') || toggleBtn.querySelector('i');
                    if (icon) {
                        if (isPassword) {
                            toggleBtn.innerHTML = '<i class="fas fa-eye-slash" id="togglePasswordIcon"></i>';
                        } else {
                            toggleBtn.innerHTML = '<i class="fas fa-eye" id="togglePasswordIcon"></i>';
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>
