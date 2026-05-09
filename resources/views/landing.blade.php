<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Infrastruktur Desa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7f6;
            color: #333;
        }

        /* NAVBAR */
        .navbar {
            background-color: #14532d !important;
            padding: 15px 0;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.25rem;
        }
        .navbar-brand img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* HERO SECTION */
        .hero {
            /* Menggunakan gambar jalan desa sebagai background */
            background: url("{{ asset('hero-desa.jpg') }}") no-repeat center center/cover;
            position: relative;
            color: white;
            padding: 120px 0 100px;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(20, 83, 45, 0.85); /* Overlay hijau tua */
            z-index: 1;
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
        }

        /* FITUR CARDS */
        .feature-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 20px;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(25, 135, 84, 0.15);
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .feature-icon {
            font-size: 36px;
            color: #198754;
        }

        /* CALL TO ACTION */
        .cta-section {
            background: #198754;
            color: white;
            padding: 60px 0;
            border-radius: 20px;
            margin-top: 50px;
        }

        /* FOOTER */
        footer {
            background: #0f3d20;
            color: #d1e7dd;
            padding: 25px 0;
            margin-top: 80px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <img src="https://ui-avatars.com/api/?name=D+I&background=198754&color=fff&rounded=true" alt="Logo Desa">
            Desa Infrastruktur
        </a>

        <div>
            <a href="/login" class="btn btn-outline-light btn-sm px-4 rounded-pill fw-semibold">Login</a>
        </div>
    </div>
</nav>

<section class="hero text-center text-lg-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-light text-success mb-3 px-3 py-2 rounded-pill shadow-sm">Transformasi Digital Desa</span>
                <h1 class="hero-title mb-4">Sistem Manajemen<br>Infrastruktur Desa</h1>
                <p class="lead mb-5 opacity-75">
                    Platform digital terpadu untuk memantau, melaporkan, dan mengelola sarana prasarana desa secara mudah, cepat, dan transparan demi kemajuan bersama.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#fitur" class="btn btn-light btn-lg px-4 rounded-pill fw-semibold text-success">
                        Pelajari Fitur
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-semibold">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk Sistem
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fitur" class="py-5 mt-5">
    <div class="container text-center">
        <h6 class="text-success fw-bold text-uppercase tracking-wide mb-2">Layanan Kami</h6>
        <h2 class="fw-bold mb-5">Fitur Unggulan Sistem</h2>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card shadow-sm">
                    <div class="icon-wrapper">
                        <i class="bi bi-building feature-icon"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Data Infrastruktur</h5>
                    <p class="text-muted mt-3">Melihat detail kondisi, spesifikasi, dan lokasi fasilitas desa secara <i>real-time</i> di satu tempat.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card shadow-sm">
                    <div class="icon-wrapper">
                        <i class="bi bi-exclamation-triangle feature-icon"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Laporan Warga</h5>
                    <p class="text-muted mt-3">Fitur pelaporan mandiri bagi masyarakat jika menemukan fasilitas umum yang rusak atau butuh perbaikan.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card shadow-sm">
                    <div class="icon-wrapper">
                        <i class="bi bi-graph-up-arrow feature-icon"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Monitoring Proyek</h5>
                    <p class="text-muted mt-3">Pantau transparansi progres pembangunan dan serapan anggaran infrastruktur di desa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pb-5">
    <div class="cta-section text-center shadow">
        <h3 class="fw-bold mb-3">Mari Bersama Membangun Desa</h3>
        <p class="mb-4 opacity-75">Laporkan fasilitas yang rusak agar segera ditindaklanjuti oleh aparat desa.</p>
        <a href="/lapor" class="btn btn-light btn-lg px-5 rounded-pill fw-bold text-success shadow-sm">Buat Laporan Sekarang</a>
    </div>
</section>

<footer class="text-center">
    <div class="container">
        <p class="mb-1 fw-semibold">Sistem Infrastruktur Desa</p>
        <small class="opacity-75">© {{ date('Y') }} Hak Cipta Dilindungi. Dibuat untuk transparansi desa.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>