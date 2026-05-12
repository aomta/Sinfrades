<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Infrastruktur Desa</title>

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
            max-width:520px;
            background:rgba(255,255,255,0.96);
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
            transition:.3s;
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

    <!-- HEADER -->
    <div class="text-center mb-4">
        <a href="/">
            <img src="https://ui-avatars.com/api/?name=D+I&background=198754&color=fff&rounded=true"
                 alt="Logo Desa"
                 class="brand-logo">
        </a>

        <h3 class="title mb-1">
            Buat Akun Baru
        </h3>

        <p class="subtitle">
            Daftar untuk menggunakan sistem infrastruktur desa
        </p>
    </div>

    <!-- ERROR GLOBAL -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-2">
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

    <!-- FORM -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NAMA -->
        <div class="mb-3">
            <label class="form-label">
                Nama Lengkap
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Masukkan nama lengkap"
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
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Masukkan email aktif"
                required
            >
        </div>

        <!-- NO HP -->
        <div class="mb-3">
            <label class="form-label">
                Nomor HP
            </label>

            <input
                type="text"
                name="no_hp"
                value="{{ old('no_hp') }}"
                class="form-control"
                placeholder="Contoh: 08123456789"
            >
        </div>

        <!-- DUSUN -->
        <div class="mb-3">
            <label class="form-label">
                Dusun
            </label>

            <input
                type="text"
                name="dusun"
                value="{{ old('dusun') }}"
                class="form-control"
                placeholder="Masukkan dusun"
            >
        </div>

        <!-- PASSWORD -->
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Password
                </label>

                <div class="input-group">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimal 8 karakter"
                        required
                    >

                    <span class="input-group-text" onclick="togglePassword('password','eye1')">
                        <i class="bi bi-eye" id="eye1"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">
                    Konfirmasi Password
                </label>

                <div class="input-group">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password"
                        required
                    >

                    <span class="input-group-text" onclick="togglePassword('password_confirmation','eye2')">
                        <i class="bi bi-eye" id="eye2"></i>
                    </span>
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <button type="submit" class="btn btn-success w-100 shadow-sm">
            <i class="bi bi-person-plus-fill"></i>
            Daftar Sekarang
        </button>

        <!-- LOGIN -->
        <p class="text-center footer-text mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-success-custom">
                Masuk di sini
            </a>
        </p>

    </form>

</div>

<script>
    function togglePassword(fieldId, eyeId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(eyeId);

        if(field.type === "password") {
            field.type = "text";
            eye.classList.remove('bi-eye');
            eye.classList.add('bi-eye-slash');
        } else {
            field.type = "password";
            eye.classList.remove('bi-eye-slash');
            eye.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>