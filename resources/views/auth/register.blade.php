<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Infrastruktur Desa</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; color: #333; }
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: #ffffff; border-radius: 16px; border: none; box-shadow: 0 15px 30px rgba(0,0,0,0.05); padding: 40px 30px; width: 100%; max-width: 500px; }
        .brand-logo { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 2px solid #198754; }
        .form-control { padding: 12px 15px; border-radius: 8px; }
        .form-control:focus { border-color: #198754; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25); }
        .btn-success { background-color: #198754; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s; }
        .btn-success:hover { background-color: #14532d; transform: translateY(-2px); }
        .text-success-custom { color: #198754; text-decoration: none; font-weight: 600; }
        .text-success-custom:hover { color: #14532d; text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card text-center">
        <a href="/">
            <img src="https://ui-avatars.com/api/?name=D+I&background=198754&color=fff&rounded=true" alt="Logo Desa" class="brand-logo">
        </a>
        <h3 class="fw-bold mb-1">Buat Akun</h3>
        <p class="text-muted mb-4 small">Daftar untuk melaporkan infrastruktur desa</p>

        <form method="POST" action="{{ route('register') }}" class="text-start">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold small">Nama Lengkap</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Masukkan email aktif">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-semibold small">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 mb-3 shadow-sm">
                Daftar Akun
            </button>

            <p class="text-center small text-muted mt-3">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-success-custom">Masuk di sini</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>