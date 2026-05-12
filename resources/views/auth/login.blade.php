<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Infrastruktur Desa</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            background:
                linear-gradient(rgb(255, 255, 255), rgba(223, 223, 223, 0.77));
            background-size:cover;
            background-position:center;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }

        .auth-card{
            width:100%;
            max-width:450px;
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(10px);
            border:none;
            border-radius:20px;
            padding:40px 35px;
            box-shadow:0 15px 40px rgba(0,0,0,0.2);
            animation:fadeIn .5s ease;
        }

        @keyframes fadeIn{
            from{
                opacity:0;
                transform:translateY(20px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        .brand-logo{
            width:75px;
            height:75px;
            border-radius:50%;
            object-fit:cover;
            border:3px solid #198754;
            margin-bottom:15px;
        }

        .title{
            font-weight:700;
            color:#14532d;
        }

        .subtitle{
            color:#6c757d;
            font-size:14px;
        }

        .form-label{
            font-weight:600;
            font-size:14px;
        }

        .form-control{
            border-radius:12px;
            padding:12px 15px;
            border:1px solid #dcdcdc;
            transition:all .3s ease;
        }

        .form-control:focus{
            border-color:#198754;
            box-shadow:0 0 0 0.25rem rgba(25,135,84,.15);
        }

        .input-group-text{
            border-radius:0 12px 12px 0;
            cursor:pointer;
            background:#fff;
        }

        .btn-success{
            background:#198754;
            border:none;
            border-radius:12px;
            padding:12px;
            font-weight:600;
            transition:.3s;
        }

        .btn-success:hover{
            background:#14532d;
            transform:translateY(-2px);
        }

        .text-success-custom{
            color:#198754;
            text-decoration:none;
            font-weight:600;
        }

        .text-success-custom:hover{
            color:#14532d;
        }

        .alert{
            border-radius:12px;
        }

        .footer-text{
            font-size:13px;
            color:#777;
        }
    </style>
</head>
<body>

<div class="auth-card">

    <div class="text-center mb-4">
        <a href="/">
            <img src="https://ui-avatars.com/api/?name=D+I&background=198754&color=fff&rounded=true"
                 class="brand-logo"
                 alt="Logo Desa">
        </a>

        <h3 class="title mb-1">
            Sistem Infrastruktur Desa
        </h3>

        <p class="subtitle">
            Silakan login untuk melanjutkan
        </p>
    </div>

    {{-- ERROR GLOBAL --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Terjadi Kesalahan
            </div>

            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STATUS --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- EMAIL --}}
        <div class="mb-3">
            <label class="form-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Masukkan email"
                required
            >
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">
                Password
            </label>

            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required
                >

                <span class="input-group-text" onclick="togglePassword()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        {{-- REMEMBER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox"
                       name="remember"
                       class="form-check-input"
                       id="remember">

                <label class="form-check-label small text-muted" for="remember">
                    Ingat saya
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-success-custom small">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-success w-100 shadow-sm">
            <i class="bi bi-box-arrow-in-right"></i>
            Masuk Sistem
        </button>

        {{-- REGISTER --}}
        <p class="text-center footer-text mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-success-custom">
                Daftar sekarang
            </a>
        </p>

    </form>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>